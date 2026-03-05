<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\PrItem;
use App\Models\Approval;
use App\Models\Department;
use App\Models\Uom;
use App\Models\Purpose;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PurchaseRequestExport;
use App\Notifications\ItemDeliveredNotification;
use App\Notifications\PrSubmittedNotification;
use App\Notifications\PrStatusUpdatedNotification;
use App\Notifications\PrActionRequiredNotification;
use App\Models\User;
use Illuminate\Support\Facades\Notification;


class PurchaseRequestController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view pr');
        $user = Auth::user();
        $query = PurchaseRequest::with(['user', 'department', 'items'])
            ->where('status', '!=', 'draft');

        
        if ($user->hasRole('user') || $user->hasAnyRole(['operational_manager', 'general_manager'])) {
            $query->where('user_id', $user->id);
        }

        // Search
        $this->applySearchFilter($query, $request->search);

        // Awaiting Approval Filter
        if ($request->boolean('awaiting_approval')) {
            if ($user->hasRole('operational_manager')) {
                $query->where('status', 'pending');
            } elseif ($user->hasRole('general_manager')) {
                $query->where('status', 'approved_om');
            } elseif ($user->hasRole('procurement')) {
                $query->where('status', 'approved_gm');
            }
        }


        // Department Filter
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $purchaseRequests = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $departments = Department::all();
        
        return view('purchase_requests.index', compact('purchaseRequests', 'departments'));
    }


    public function create()
    {
        if (!Auth::user()->department_id) {
            return redirect()->route('dashboard')->with('error', 'Akun Anda belum terhubung dengan Departemen apa pun. Silakan hubungi admin.');
        }
        $departments = Department::where('is_active', true)->get();
        $uoms = Uom::all();
        $purposes = Purpose::all();
        return view('purchase_requests.create', compact('departments', 'uoms', 'purposes'));
    }


    public function store(Request $request)
    {
        \Log::info('PR Store attempt', $request->all());
        
        if (!Auth::user()->department_id) {
            return redirect()->back()->with('error', 'Akun Anda belum terhubung dengan Departemen apa pun.')->withInput();
        }

        \DB::beginTransaction();
        try {
            $request->validate([
            'request_date' => 'required|date',
            'purpose' => 'required|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.uom' => 'required|string|max:50',
            'items.*.due_date' => 'nullable|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.attachment' => 'nullable|file|max:2048',
        ]);

        $isDraft = $request->action === 'draft';
        
        $purchaseRequest = PurchaseRequest::create([
            'user_id' => Auth::id(),
            'department_id' => Auth::user()->department_id,
            'request_date' => $request->request_date,
            'purpose' => $request->purpose,
            'status' => $isDraft ? 'draft' : 'pending',
            'total_amount' => 0,
        ]);


        $totalAmount = 0;
        foreach ($request->items as $item) {
            $attachmentPath = null;
            if (isset($item['attachment']) && $item['attachment']->isValid()) {
                $attachmentPath = $item['attachment']->store('pr-attachments', 'public');
            }

            $itemTotal = ($item['estimated_price'] ?? 0) * $item['quantity'];
            $totalAmount += $itemTotal;

            PrItem::create([
                'purchase_request_id' => $purchaseRequest->id,
                'item_name' => $item['item_name'],
                'description' => $item['description'] ?? null,
                'quantity' => $item['quantity'],
                'uom' => $item['uom'],
                'estimated_price' => $item['estimated_price'] ?? 0,
                'total_price' => $itemTotal,
                'due_date' => $item['due_date'] ?? null,
                'attachment' => $attachmentPath,
                'status' => 'pending',
            ]);
        }

            $purchaseRequest->update(['total_amount' => $totalAmount]);

            if (!$isDraft) {
                // Create initial approval record for Operational Manager
                Approval::create([
                    'purchase_request_id' => $purchaseRequest->id,
                    'approver_id' => null, // Will be assigned when someone approves
                    'approver_role' => 'operational_manager',
                    'approval_type' => 'om',
                    'status' => 'pending',
                ]);
            }


            \DB::commit();

            if (!$isDraft) {
                // Notify Management (OM of same dept + Superadmins)
                $managers = $this->getSharedRecipients($purchaseRequest->department_id);
                
                \Log::info('PR Submitted. Notifying managers:', [
                    'pr_id' => $purchaseRequest->id,
                    'dept_id' => $purchaseRequest->department_id,
                    'notified_users' => $managers->pluck('name', 'id')->toArray()
                ]);
                
                if ($managers->isNotEmpty()) {
                    Notification::send($managers, new PrSubmittedNotification($purchaseRequest));
                }
            }

            return redirect()->route('purchase-requests.show', $purchaseRequest)
                ->with('success', 'Purchase Request created successfully.');
                
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('PR Store failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan PR: ' . $e->getMessage())->withInput();
        }
    }

    public function show(PurchaseRequest $purchaseRequest)
    {
        $this->authorize('view pr', $purchaseRequest);
        
        $purchaseRequest->load(['items', 'approvals', 'user', 'department']);
        return view('purchase_requests.show', compact('purchaseRequest'));
    }

    public function edit(PurchaseRequest $purchaseRequest)
    {
        $this->authorize('edit pr', $purchaseRequest);
        
        if (!$purchaseRequest->isEditable()) {
            return redirect()->route('purchase-requests.show', $purchaseRequest)
                ->with('error', 'This PR is not in an editable state.');
        }
        
        $departments = Department::where('is_active', true)->get();
        $uoms = Uom::all();
        $purposes = Purpose::all();
        $isPending = $purchaseRequest->status === 'pending';
        return view('purchase_requests.edit', compact('purchaseRequest', 'departments', 'uoms', 'purposes', 'isPending'));
    }



    public function update(Request $request, PurchaseRequest $purchaseRequest)
    {
        \Log::info('PR Update attempt', ['id' => $purchaseRequest->id, 'data' => $request->all()]);
        $this->authorize('edit pr', $purchaseRequest);

        \DB::beginTransaction();
        try {
            $request->validate([
            'request_date' => 'required|date',
            'purpose' => 'required|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.uom' => 'required|string|max:50',
            'items.*.due_date' => 'nullable|string|max:255',
            'items.*.description' => 'nullable|string',
        ]);

        // Update existing items or create new ones
        $totalAmount = 0;
        $submittedItemIds = [];

        foreach ($request->items as $itemData) {
            $attachmentPath = null;
            if (isset($itemData['attachment']) && $itemData['attachment']->isValid()) {
                $attachmentPath = $itemData['attachment']->store('pr-attachments', 'public');
            }

            if (isset($itemData['id'])) {
                    $item = PrItem::where('id', $itemData['id'])
                        ->where('purchase_request_id', $purchaseRequest->id)
                        ->first();

                    if ($item) {
                        $submittedItemIds[] = $item->id;
                        
                        $isRejected = str_starts_with($item->status, 'rejected');
                        $isDraft = $purchaseRequest->status === 'draft';
                        $isPending = $item->status === 'pending';
                        
                        // Item is editable IF:
                        // 1. It was rejected
                        // 2. The entire PR is a draft
                        // 3. The item is still pending and NO manager has touched the PR yet (for quick fixes)
                        $canEditItem = $isRejected || $isDraft || ($isPending && $purchaseRequest->isEditable());
                        
                        if ($canEditItem) {
                            $item->update([
                                'item_name' => $itemData['item_name'],
                                'description' => $itemData['description'] ?? null,
                                'quantity' => $itemData['quantity'],
                                'uom' => $itemData['uom'],
                                'due_date' => $itemData['due_date'] ?? null,
                                'attachment' => $attachmentPath ?? $item->attachment,
                                'status' => 'pending', // Re-submit
                                'revision_count' => $item->revision_count + ($isRejected ? 1 : 0),
                                'reject_reason' => null,
                                'rejected_by' => null,
                                'rejected_at' => null,
                            ]);
                        }
                    }
            } else {
                // New item added during revision
                $newItem = PrItem::create([
                    'purchase_request_id' => $purchaseRequest->id,
                    'item_name' => $itemData['item_name'],
                    'description' => $itemData['description'] ?? null,
                    'quantity' => $itemData['quantity'],
                    'uom' => $itemData['uom'],
                    'estimated_price' => 0,
                    'total_price' => 0,
                    'due_date' => $itemData['due_date'] ?? null,
                    'attachment' => $attachmentPath,
                    'status' => 'pending',
                ]);
                $submittedItemIds[] = $newItem->id;
            }
        }

        // Remove items that are NOT present in the submission (deleted by user)
        // We only delete items that are safely deletable (pending, rejected, or if PR is draft)
        // We protect approved/processed items from being deleted
        $purchaseRequest->items()
            ->whereNotIn('id', $submittedItemIds)
            ->where(function($q) use ($purchaseRequest) {
                // If the PR itself is a draft, we can delete any item belonging to it
                if ($purchaseRequest->status === 'draft') {
                    return;
                }
                
                // Otherwise only delete pending or rejected items
                $q->whereIn('status', ['pending', 'rejected_om', 'rejected_gm', 'rejected_proc']);
            })
            ->delete();

        // Recalculate total amount (though currently 0 as per user request to remove prices)
        // $totalAmount remains 0

            $isDraft = $request->action === 'draft';

            $purchaseRequest->update([
                'request_date' => $request->request_date,
                'purpose' => $request->purpose,
                'total_amount' => $totalAmount,
                'status' => $isDraft ? 'draft' : 'pending', // Re-submit for approval or keep as draft
            ]);

            if (!$isDraft) {
                // Ensure OM approval record exists if not already there (e.g. from draft or reset)
                $hasOmApproval = $purchaseRequest->approvals()->where('approver_role', 'operational_manager')->exists();
                if (!$hasOmApproval) {
                    Approval::create([
                        'purchase_request_id' => $purchaseRequest->id,
                        'approver_role' => 'operational_manager',
                        'approval_type' => 'om',
                        'status' => 'pending',
                    ]);
                }

                // Notify Management (OM of same dept + Superadmins)
                $managers = $this->getSharedRecipients($purchaseRequest->department_id);
                
                \Log::info('PR Updated/Re-submitted. Notifying managers:', [
                    'pr_id' => $purchaseRequest->id,
                    'dept_id' => $purchaseRequest->department_id,
                    'notified_users' => $managers->pluck('name', 'id')->toArray()
                ]);

                if ($managers->isNotEmpty()) {
                    Notification::send($managers, new PrSubmittedNotification($purchaseRequest));
                }
            }





            \DB::commit();

            return redirect()->route('purchase-requests.show', $purchaseRequest)
                ->with('success', 'Purchase Request updated successfully.');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('PR Update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal update PR: ' . $e->getMessage())->withInput();
        }
    }

    public function approveItem(Request $request, PrItem $item)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        
        if (($user->hasRole('operational_manager') || $user->hasRole('superadmin')) && $item->status === 'pending') {
            $item->update(['status' => 'approved_om']);
            
            Approval::create([
                'purchase_request_id' => $item->purchase_request_id,
                'pr_item_id' => $item->id,
                'approver_id' => $user->id,
                'approver_role' => 'operational_manager',
                'approval_type' => 'om',
                'status' => 'approved',
                'notes' => $request->notes,
                'approved_at' => now(),
            ]);
            
            // Check if all items are approved by OM
            $allApproved = $item->purchaseRequest->items()
                ->where('status', '!=', 'approved_om')
                ->doesntExist();
            
            if ($allApproved) {
                $item->purchaseRequest->update(['status' => 'approved_om']);
                
                // Notify General Manager(s) + Superadmins
                $gms = User::role(['general_manager', 'superadmin'])->get();
                Notification::send($gms, new PrActionRequiredNotification($item->purchaseRequest, "PR {$item->purchaseRequest->pr_number} menunggu persetujuan General Manager."));
            }
            
            // Notify requester + Superadmins + Department OM
            $recipients = $this->getSharedRecipients($item->purchaseRequest->department_id, $item->purchaseRequest->user);
            $message = "Item '{$item->item_name}' telah disetujui oleh Operational Manager.";
            if ($request->filled('notes')) {
                $message .= " Catatan: {$request->notes}";
            }
            Notification::send($recipients, new PrStatusUpdatedNotification($item->purchaseRequest, $message));

            
        } elseif (($user->hasRole('general_manager') || $user->hasRole('superadmin')) && $item->status === 'approved_om') {
            $item->update(['status' => 'approved_gm']);
            
            Approval::create([
                'purchase_request_id' => $item->purchase_request_id,
                'pr_item_id' => $item->id,
                'approver_id' => $user->id,
                'approver_role' => 'general_manager',
                'approval_type' => 'gm',
                'status' => 'approved',
                'notes' => $request->notes,
                'approved_at' => now(),
            ]);
            
            $allApproved = $item->purchaseRequest->items()
                ->where('status', '!=', 'approved_gm')
                ->doesntExist();

            // Notify requester + Superadmins + Department OM
            $recipients = $this->getSharedRecipients($item->purchaseRequest->department_id, $item->purchaseRequest->user);
            $message = "Item '{$item->item_name}' telah disetujui oleh General Manager.";
            if ($request->filled('notes')) {
                $message .= " Catatan: {$request->notes}";
            }
            Notification::send($recipients, new PrStatusUpdatedNotification($item->purchaseRequest, $message));

            if ($allApproved) {
                $item->purchaseRequest->update(['status' => 'approved_gm']);
                
                // Notify Procurement + Superadmins
                $procurement = User::role(['procurement', 'superadmin'])->get();
                Notification::send($procurement, new PrActionRequiredNotification($item->purchaseRequest, "PR {$item->purchaseRequest->pr_number} menunggu proses Procurement."));
            }

            
        } elseif (($user->hasRole('procurement') || $user->hasRole('superadmin')) && $item->status === 'approved_gm') {
            $item->update(['status' => 'approved_proc']);
            
            // Notify requester + Superadmins + Department OM
            $recipients = $this->getSharedRecipients($item->purchaseRequest->department_id, $item->purchaseRequest->user);
            $message = "Item '{$item->item_name}' telah disetujui oleh Procurement.";
            if ($request->filled('notes')) {
                $message .= " Catatan: {$request->notes}";
            }
            Notification::send($recipients, new PrStatusUpdatedNotification($item->purchaseRequest, $message));

            Approval::create([

                'purchase_request_id' => $item->purchase_request_id,
                'pr_item_id' => $item->id,
                'approver_id' => $user->id,
                'approver_role' => 'procurement',
                'approval_type' => 'procurement',
                'status' => 'approved',
                'notes' => $request->notes,
                'approved_at' => now(),
            ]);
            
            $allApproved = $item->purchaseRequest->items()
                ->where('status', '!=', 'approved_proc')
                ->doesntExist();
            
            if ($allApproved) {
                $item->purchaseRequest->update(['status' => 'approved_proc']);
            }
        }

        return redirect()->back()->with('success', 'Item approved successfully.');
    }

    public function rejectItem(Request $request, PrItem $item)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        
        if (($user->hasRole('operational_manager') || $user->hasRole('superadmin')) && $item->status === 'pending') {
            $status = 'rejected_om';
            $approverRole = 'operational_manager';
        } elseif (($user->hasRole('general_manager') || $user->hasRole('superadmin')) && $item->status === 'approved_om') {
            $status = 'rejected_gm';
            $approverRole = 'general_manager';
        } elseif (($user->hasRole('procurement') || $user->hasRole('superadmin')) && $item->status === 'approved_gm') {
            $status = 'rejected_proc';
            $approverRole = 'procurement';
        } else {
            return redirect()->back()->with('error', 'Invalid rejection action.');
        }

        $item->update([
            'status' => $status,
            'reject_reason' => $request->reject_reason,
            'rejected_by' => $user->id,
            'rejected_at' => now(),
        ]);

        // Notify requester + Superadmins + Department OM
        $recipients = $this->getSharedRecipients($item->purchaseRequest->department_id, $item->purchaseRequest->user);
        Notification::send($recipients, new PrStatusUpdatedNotification($item->purchaseRequest, "Item '{$item->item_name}' ditolak. Catatan validasi: " . $request->reject_reason));



        Approval::create([
            'purchase_request_id' => $item->purchase_request_id,
            'pr_item_id' => $item->id,
            'approver_id' => $user->id,
            'approver_role' => $approverRole,
            'approval_type' => str_replace('rejected_', '', $status),
            'status' => 'rejected',
            'notes' => $request->reject_reason,
            'approved_at' => now(),
        ]);

        // Update PR status if all items are rejected
        $allRejected = $item->purchaseRequest->items()
            ->whereNotIn('status', [$status, 'rejected_' . $status])
            ->doesntExist();
        
        if ($allRejected) {
            $item->purchaseRequest->update(['status' => $status]);
        }

        return redirect()->back()->with('success', 'Item rejected successfully.');
    }

    public function sendValidationNote(Request $request, PrItem $item)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $role = $user->getRoleNames()->first();

        $canSend = false;
    $approvalType = 'unknown';
    
    if ($item->purchaseRequest->user_id == $user->id) {
        $canSend = true;
        $approvalType = 'requester';
    } elseif ($role === 'superadmin' && $item->status === 'pending') {
        $canSend = true;
        $approvalType = 'om';
        $role = 'operational_manager';
    } elseif ($role === 'superadmin' && $item->status === 'approved_om') {
        $canSend = true;
        $approvalType = 'gm';
        $role = 'general_manager';
    } elseif ($role === 'superadmin' && $item->status === 'approved_gm') {
        $canSend = true;
        $approvalType = 'procurement';
        $role = 'procurement';
    } elseif ($role === 'operational_manager' && $item->status === 'pending') {
        $canSend = true;
        $approvalType = 'om';
    } elseif ($role === 'general_manager' && $item->status === 'approved_om') {
        $canSend = true;
        $approvalType = 'gm';
    } elseif ($role === 'procurement' && $item->status === 'approved_gm') {
        $canSend = true;
        $approvalType = 'procurement';
    }

        if (!$canSend) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengirim catatan pada status item ini.');
        }

        Approval::create([
            'purchase_request_id' => $item->purchase_request_id,
            'pr_item_id' => $item->id,
            'approver_id' => $user->id,
            'approver_role' => $role,
            'approval_type' => $approvalType,
            'status' => 'pending',
            'notes' => $request->notes,
            'approved_at' => now(),
        ]);

        $recipients = $this->getSharedRecipients($item->purchaseRequest->department_id, $item->purchaseRequest->user);
        
        $senderName = $approvalType === 'requester' ? "Requester ({$user->name})" : strtoupper(str_replace('_', ' ', $role));
        
        Notification::send(
            $recipients,
            new PrStatusUpdatedNotification(
                $item->purchaseRequest,
                "Catatan untuk item '{$item->item_name}' dari " . $senderName . ": {$request->notes}"
            )
        );

        return redirect()->back()->with('success', 'Catatan berhasil dikirim.');
    }

    public function reviseItem(Request $request, PrItem $item)
    {
        $user = Auth::user();
        $oldPr = $item->purchaseRequest;

        // Only the owner or superadmin can revise
        if ($user->id !== $oldPr->user_id && !$user->hasRole('superadmin')) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Get all rejected items for this PR
        $rejectedItems = $oldPr->items()
            ->whereIn('status', ['rejected_om', 'rejected_gm', 'rejected_proc'])
            ->get();

        if ($rejectedItems->isEmpty()) {
            return redirect()->back()->with('error', 'No rejected items found to revise.');
        }

        \DB::beginTransaction();
        try {
            // 1. Create NEW Purchase Request
            $newPr = PurchaseRequest::create([
                'user_id' => $oldPr->user_id,
                'department_id' => $oldPr->department_id,
                'request_date' => now(),
                'purpose' => $oldPr->purpose,
                'status' => 'draft', // Set to draft so it is editable
                'notes' => 'Bulk Revision from ' . $oldPr->pr_number,

                'total_amount' => 0,
            ]);


            $movedItemsNames = [];
            foreach ($rejectedItems as $rejectedItem) {
                // 2. Move Item to New PR and Reset Status
                $rejectedItem->update([
                    'purchase_request_id' => $newPr->id,
                    'status' => 'pending',
                    'reject_reason' => null,
                    'rejected_by' => null,
                    'rejected_at' => null,
                    'revision_count' => $rejectedItem->revision_count + 1,
                ]);
                $movedItemsNames[] = $rejectedItem->item_name;
            }

            // 3. Recalculate Totals
            // Since prices were removed/set to 0 by user request earlier, total_amount remains 0
            // but we follow the logic if needed
            $newPrTotal = $newPr->items()->sum('total_price');
            $newPr->update(['total_amount' => $newPrTotal]);

            // Old PR Logic
            $oldPrRemainingTotal = $oldPr->items()->sum('total_price');
            $revisionNote = "\n[System] Items (" . implode(', ', $movedItemsNames) . ") revised to {$newPr->pr_number}.";
            
            $updateData = [
                'total_amount' => $oldPrRemainingTotal,
                'notes' => $oldPr->notes . $revisionNote
            ];

            // Check if Old PR is empty and update status if needed
            if ($oldPr->items()->count() == 0) {
                 $updateData['status'] = 'cancelled';
                 $updateData['notes'] .= "\n[System] PR Cancelled (All items revised).";
            }
            
            // Notify Management about the new revision PR (OM of same dept + Superadmins)
            $managers = User::role('superadmin')->get()
                ->merge(User::role('operational_manager')->where('department_id', $newPr->department_id)->get());
            Notification::send($managers, new PrSubmittedNotification($newPr));

            // Notify requester about revision + Superadmins
            $requesterAndAdmins = User::role('superadmin')->get()->push($oldPr->user);
            Notification::send($requesterAndAdmins, new PrStatusUpdatedNotification($newPr, "Item yang ditolak dari {$oldPr->pr_number} telah dipindahkan ke PR baru {$newPr->pr_number} untuk direvisi."));



            // Update or delete old PR
            if ($oldPr->items()->count() == 0) {
                 $oldPr->delete();
            } else {
                 $oldPr->update($updateData);
            }

            \DB::commit();

            return redirect()->route('purchase-requests.edit', $newPr)->with('success', count($rejectedItems) . ' items have been moved to a new PR. Please review and update details.');

        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Bulk Revision failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to revise items: ' . $e->getMessage());
        }
    }


    public function destroy(PurchaseRequest $purchaseRequest)
    {
        // Check ownership/permission
        if (auth()->id() !== $purchaseRequest->user_id && !auth()->user()->hasRole('superadmin')) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Check deletability using model logic
        if ($purchaseRequest->isDeletable()) {
            $purchaseRequest->delete();
            return redirect()->route('purchase-requests.index')->with('success', 'Purchase Request has been deleted.');
        }

        return redirect()->back()->with('error', 'This PR cannot be deleted (must be Draft or truly Pending without approvals).');
    }

    public function preview(PurchaseRequest $purchaseRequest)
    {
        // Load items, excluding rejected ones (Show Pending, Approved, etc.)
        $purchaseRequest->load(['user', 'department', 'items' => function($query) {
            $query->whereNotIn('status', ['rejected_om', 'rejected_gm', 'rejected_proc', 'cancelled']);
        }]);

        // Removed strict check for empty items to allow viewing Draft/Pending PRs
        // if ($purchaseRequest->items->isEmpty()) ...

        return view('purchase_requests.export', [
            'purchaseRequest' => $purchaseRequest
        ]);
    }

    public function export(PurchaseRequest $purchaseRequest)
    {
        // Load items, excluding rejected ones
        $purchaseRequest->load(['user', 'department', 'items' => function($query) {
            $query->whereNotIn('status', ['rejected_om', 'rejected_gm', 'rejected_proc', 'cancelled']);
        }]);

        // Removed strict check
        
        $pdf = PDF::loadView('purchase_requests.export', [
            'purchaseRequest' => $purchaseRequest
        ]);
        
        return $pdf->download("PR-{$purchaseRequest->pr_number}.pdf");
    }

    public function exportExcel()
    {
        return Excel::download(new PurchaseRequestExport, 'purchase-requests.xlsx');
    }

    public function updateItemStatus(Request $request, PrItem $item)
    {
        $this->authorize('edit pr', $item->purchaseRequest);
        
        $request->validate([
            'status' => 'required|in:approved_gm,ordered,delivered,completed'
        ]);

        $updateData = ['status' => $request->status];
        
        if ($request->status === 'approved_gm') {
            $updateData['processed_at'] = now();
            $msg = "Item '{$item->item_name}' telah disetujui (Approved).";
        } elseif ($request->status === 'ordered') {
            $updateData['ordered_at'] = now();
            $msg = "Item '{$item->item_name}' sedang dalam proses pemesanan (Ordered).";
        } elseif ($request->status === 'delivered') {
            $updateData['delivered_at'] = now();
            $msg = "Item '{$item->item_name}' telah dikirim (Delivered).";
            // Notify user about status change (using legacy notification if needed, but we use status update for consistency)
            // $item->purchaseRequest->user->notify(new ItemDeliveredNotification($item));
        } elseif ($request->status === 'completed') {
            $updateData['completed_at'] = now();
            $msg = "Item '{$item->item_name}' telah selesai diproses (Completed).";
        }

        $item->update($updateData);
        
        // Notify requester + Superadmins + Department OM
        $recipients = $this->getSharedRecipients($item->purchaseRequest->department_id, $item->purchaseRequest->user);
        Notification::send($recipients, new PrStatusUpdatedNotification($item->purchaseRequest, $msg));



        return redirect()->back()->with('success', 'Item status updated successfully.');
    }

    public function rejected(Request $request)
    {
        $this->authorize('view pr');
        $user = Auth::user();
        
        $query = PurchaseRequest::with(['user', 'department', 'items'])
            ->whereHas('items', function($q) {
                $q->whereIn('status', ['rejected_om', 'rejected_gm', 'rejected_proc']);
            });

        if (!$user->hasAnyRole(['superadmin', 'operational_manager', 'general_manager', 'procurement'])) {
            $query->where('user_id', $user->id);
        }

        $this->applySearchFilter($query, $request->search);

        $purchaseRequests = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $departments = Department::all();
        $title = "Rejected Purchase Requests";

        return view('purchase_requests.index', compact('purchaseRequests', 'departments', 'title'));
    }

    public function drafts(Request $request)
    {
        $this->authorize('view pr');
        $user = Auth::user();
        
        $query = PurchaseRequest::with(['user', 'department', 'items'])
            ->where('status', 'draft');

        if (!$user->hasAnyRole(['superadmin'])) {
            $query->where('user_id', $user->id);
        }

        $this->applySearchFilter($query, $request->search);

        $purchaseRequests = $query->orderBy('updated_at', 'desc')->paginate(10)->withQueryString();
        $departments = Department::all();
        $title = "Draft Purchase Requests";

        return view('purchase_requests.index', compact('purchaseRequests', 'departments', 'title'));
    }

    public function approvalQueue(Request $request)
    {
        $this->authorize('view pr');
        $user = Auth::user();

        $query = PurchaseRequest::with(['user', 'department', 'items'])
            ->where('status', '!=', 'draft');

        if ($user->hasRole('superadmin')) {
            $query->whereIn('status', ['pending', 'approved_om']);
        } elseif ($user->hasRole('operational_manager')) {
            $query->where('status', 'pending');
        } elseif ($user->hasRole('general_manager')) {
            $query->where('status', 'approved_om');
        } else {
            abort(403);
        }

        $this->applySearchFilter($query, $request->search);

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $purchaseRequests = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $departments = Department::all();
        $title = 'Approval Queue (OM/GM)';
        $hideCreateButton = true;

        return view('purchase_requests.index', compact('purchaseRequests', 'departments', 'title', 'hideCreateButton'));
    }

    public function checkNotifications()
    {
        $user = auth()->user();
        if (!$user) return response()->json(['unread_count' => 0, 'latest' => null]);
        
        $unreadCount = $user->unreadNotifications->count();
        $latestNotification = $user->unreadNotifications->first();

        return response()->json([
            'unread_count' => $unreadCount,
            'latest' => $latestNotification ? [
                'id' => $latestNotification->id,
                'message' => $latestNotification->data['message'],
                'url' => route('notifications.mark-as-read', $latestNotification->id)
            ] : null
        ]);
    }

    private function getSharedRecipients($departmentId, $requester = null)
    {
        $superadmins = User::role('superadmin')->get();
        // Ensure we find OMs in the correct department
        $departmentOms = User::role('operational_manager')
            ->where('department_id', $departmentId)
            ->get();
            
        $recipients = $superadmins->merge($departmentOms);
        
        if ($requester) {
            $recipients = $recipients->push($requester);
        }
        
        $authId = auth()->id();
        \Log::info('getSharedRecipients Check', [
            'auth_id' => $authId,
            'dept_id' => $departmentId,
            'requester_id' => $requester ? $requester->id : 'null',
            'initial_count' => $recipients->count(),
            'initial_ids' => $recipients->pluck('id')->toArray()
        ]);

        $filtered = $recipients->unique('id')->reject(function ($user) use ($authId) {
            // Use loose comparison to handle string/int mismatches
            return $user->id == $authId; 
        });

        \Log::info('getSharedRecipients Result', [
            'final_count' => $filtered->count(),
            'final_ids' => $filtered->pluck('id')->toArray()
        ]);

        return $filtered;
    }

    private function applySearchFilter($query, $search): void
    {
        if (!$search) {
            return;
        }

        $query->where(function ($q) use ($search) {
            $q->where('pr_number', 'like', "%{$search}%")
                ->orWhere('purpose', 'like', "%{$search}%")
                ->orWhereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('department', function ($qd) use ($search) {
                    $qd->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                })
                ->orWhereHas('items', function ($qi) use ($search) {
                    $qi->where('item_name', 'like', "%{$search}%")
                        ->orWhere('uom', 'like', "%{$search}%");
                });
        });
    }

}


