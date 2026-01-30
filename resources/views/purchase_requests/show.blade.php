<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             PR #{{ $purchaseRequest->pr_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="alert alert-success mb-4">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger mb-4">{{ session('error') }}</div>
            @endif

            <!-- Header Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Requester:</strong> {{ $purchaseRequest->user->name }} ({{ $purchaseRequest->department->name }})</p>
                            <p><strong>Date:</strong> {{ $purchaseRequest->request_date->format('d M Y') }}</p>
                            <p><strong>Purpose:</strong> {{ $purchaseRequest->purpose }}</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <p><strong>Status:</strong> <span class="badge badge-info">{{ ucfirst($purchaseRequest->status) }}</span></p>
                            
                            @if($purchaseRequest->isEditable() && auth()->id() == $purchaseRequest->user_id)
                                <a href="{{ route('purchase-requests.edit', $purchaseRequest) }}" class="btn btn-warning btn-sm mt-2 mr-2">
                                    <i class="fas fa-edit"></i> Edit Request
                                </a>
                            @endif

                            <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="openPreviewModal('{{ route('purchase-requests.preview', $purchaseRequest) }}', '{{ route('purchase-requests.export', $purchaseRequest) }}')">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-lg font-medium">Items List</h3>
                        @if($purchaseRequest->hasRejectedItems() && (Auth::id() == $purchaseRequest->user_id || Auth::user()->hasRole('superadmin')))
                            <form action="{{ route('purchase-requests.revise-item', $purchaseRequest->items->whereIn('status', ['rejected_om', 'rejected_gm', 'rejected_proc'])->first()) }}" method="POST" onsubmit="return confirm('Revise all rejected items? They will be moved to a new PR for revision.');">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm shadow-sm">
                                    <i class="fas fa-sync-alt mr-1"></i> Revise All Rejected Items
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Keterangan</th>
                                    <th>Qty/UOM</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchaseRequest->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->item_name }}</strong>
                                        @if($item->attachment)
                                            <br><a href="{{ asset('storage/' . $item->attachment) }}" 
                                                   class="text-blue-600 preview-attachment" 
                                                   data-url="{{ asset('storage/' . $item->attachment) }}"
                                                   data-filename="{{ basename($item->attachment) }}">
                                                <i class="fas fa-search-plus"></i> View Attachment
                                            </a>
                                        @endif
                                        @if($item->reject_reason)
                                            <div class="text-danger mt-1">
                                                <strong>Rejected:</strong> {{ $item->reject_reason }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $item->description ?? '-' }}</td>
                                    <td>{{ $item->quantity }} {{ $item->uom }}</td>
                                    <td>{{ $item->due_date ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->status == 'pending' ? 'warning' : ($item->status == 'rejected_om' || $item->status == 'rejected_gm' || $item->status == 'rejected_proc' ? 'danger' : 'success') }}">
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                        @if($item->revision_count > 0)
                                            <span class="badge badge-info ml-1" title="Item has been revised {{ $item->revision_count }} times">Revised ({{ $item->revision_count }})</span>
                                        @endif
                                        <div class="small mt-2" style="font-size: 0.7rem; line-height: 1.2;">
                                            <div class="text-muted">Created: {{ $item->created_at->format('d/m/y H:i') }}</div>
                                            
                                            @php
                                                $omApproval = $item->approvals->where('approver_role', 'operational_manager')->first();
                                                $gmApproval = $item->approvals->where('approver_role', 'general_manager')->first();
                                                $procApproval = $item->approvals->where('approver_role', 'procurement')->where('status', 'approved')->first();
                                            @endphp

                                            @if($omApproval) 
                                                <div class="{{ $omApproval->status == 'approved' ? 'text-success' : 'text-danger' }}">
                                                    OM: {{ $omApproval->status == 'approved' ? 'Approve' : 'Reject' }} ({{ $omApproval->approved_at->format('d/m/y H:i') }})
                                                    @if($omApproval->purchase_request_id != $purchaseRequest->id) <span class="text-muted small font-italic">(Revised)</span> @endif
                                                </div> 
                                            @endif
                                            @if($gmApproval) 
                                                <div class="{{ $gmApproval->status == 'approved' ? 'text-success' : 'text-danger' }}">
                                                    GM: {{ $gmApproval->status == 'approved' ? 'Approve' : 'Reject' }} ({{ $gmApproval->approved_at->format('d/m/y H:i') }})
                                                    @if($gmApproval->purchase_request_id != $purchaseRequest->id) <span class="text-muted small font-italic">(Revised)</span> @endif
                                                </div> 
                                            @endif
                                            @if($procApproval) 
                                                <div class="text-success">
                                                    Proc: Approve ({{ $procApproval->approved_at->format('d/m/y H:i') }})
                                                    @if($procApproval->purchase_request_id != $purchaseRequest->id) <span class="text-muted small font-italic">(Revised)</span> @endif
                                                </div> 
                                            @endif
                                            
                                            @if($item->rejected_at) <div class="text-danger">Rejected: {{ $item->rejected_at->format('d/m/y H:i') }}</div> @endif
                                            @if($item->processed_at) <div class="text-info">Ready to Process: {{ $item->processed_at->format('d/m/y H:i') }}</div> @endif
                                            @if($item->ordered_at) <div class="text-primary">Ordered: {{ $item->ordered_at->format('d/m/y H:i') }}</div> @endif
                                            @if($item->delivered_at) <div class="text-primary">Delivered: {{ $item->delivered_at->format('d/m/y H:i') }}</div> @endif
                                            @if($item->completed_at) <div class="text-success">Completed: {{ $item->completed_at->format('d/m/y H:i') }}</div> @endif
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Approval/Rejection Actions -->
                                        @php
                                            $canApprove = false;
                                            $role = Auth::user()->getRoleNames()->first();
                                            
                                            if ($purchaseRequest->status !== 'draft') {
                                                if ($role == 'operational_manager' && $item->status == 'pending') $canApprove = true;
                                                if ($role == 'general_manager' && $item->status == 'approved_om') $canApprove = true;
                                                if ($role == 'procurement' && $item->status == 'approved_gm') $canApprove = true;
                                            }
                                        @endphp


                                        @if($canApprove)
                                            <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#approveModal-{{ $item->id }}">
                                                Approve
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#rejectModal-{{ $item->id }}">
                                                Reject
                                            </button>
                                        @endif

                                        <!-- Procurement Status Update -->
                                        @if($role == 'procurement' && in_array($item->status, ['approved_gm', 'approved_proc', 'ordered', 'delivered', 'completed']))
                                            <form action="{{ route('purchase-requests.update-item-status', $item) }}" method="POST" class="mt-1">
                                                @csrf
                                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                    <option value="approved_gm" {{ $item->status == 'approved_gm' ? 'selected' : '' }}>
                                                        Ready to Process {{ $item->processed_at ? '(' . $item->processed_at->format('d/m H:i') . ')' : '' }}
                                                    </option>
                                                    <option value="ordered" {{ $item->status == 'ordered' ? 'selected' : '' }}>
                                                        Ordered {{ $item->ordered_at ? '(' . $item->ordered_at->format('d/m H:i') . ')' : '' }}
                                                    </option>
                                                    <option value="delivered" {{ $item->status == 'delivered' ? 'selected' : '' }}>
                                                        Delivered {{ $item->delivered_at ? '(' . $item->delivered_at->format('d/m H:i') . ')' : '' }}
                                                    </option>
                                                    <option value="completed" {{ $item->status == 'completed' ? 'selected' : '' }}>
                                                        Completed {{ $item->completed_at ? '(' . $item->completed_at->format('d/m H:i') . ')' : '' }}
                                                    </option>
                                                </select>
                                            </form>
                                        @endif
                                         <!-- Revision Action moved to bulk button above table -->
                                    </td>
                                </tr>

                                <!-- Approve Modal -->
                                <div class="modal fade" id="approveModal-{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="{{ route('purchase-requests.approve-item', $item) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Approve Item: {{ $item->item_name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Notes (Optional)</label>
                                                        <textarea name="notes" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Confirm Approve</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Reject Modal -->
                                <div class="modal fade" id="rejectModal-{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="{{ route('purchase-requests.reject-item', $item) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Item: {{ $item->item_name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Reason for Rejection *</label>
                                                        <textarea name="reject_reason" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Confirm Reject</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Preview Modal -->
    <div class="modal fade" id="attachmentPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewFilename">File Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0" id="previewBody">
                    <!-- Preview content will be injected here -->
                    <div class="text-center p-5 loading-spinner">
                        <i class="fas fa-spinner fa-spin fa-3x"></i>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" id="downloadLink" class="btn btn-primary" download>
                        <i class="fas fa-download"></i> Download Original
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.preview-attachment').on('click', function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                const filename = $(this).data('filename');
                const extension = filename.split('.').pop().toLowerCase();
                
                $('#previewFilename').text(filename);
                $('#downloadLink').attr('href', url);
                $('#previewBody').html('<div class="text-center p-5"><i class="fas fa-spinner fa-spin fa-3x"></i></div>');
                
                $('#attachmentPreviewModal').modal('show');
                
                let content = '';
                if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
                    content = `<div class="text-center p-3"><img src="${url}" class="img-fluid rounded shadow" style="max-height: 80vh;"></div>`;
                } else if (extension === 'pdf') {
                    content = `<iframe src="${url}#view=FitH" width="100%" height="600px" style="border: none;"></iframe>`;
                } else {
                    content = `
                        <div class="text-center p-5">
                            <i class="fas fa-file-alt fa-5x mb-3 text-muted"></i>
                            <h4>Format tidak mendukung pratinjau langsung</h4>
                            <p>Silakan unduh file untuk melihat kontennya.</p>
                            <a href="${url}" class="btn btn-lg btn-primary mt-2" download>Unduh Sekarang</a>
                        </div>`;
                }
                
                // Small delay for smooth transition
                setTimeout(() => {
                    $('#previewBody').html(content);
                }, 300);
            });

            // PR Preview Modal Functions
            window.openPreviewModal = function(previewUrl, downloadUrl) {
                $('#prPreviewFrame').attr('src', previewUrl);
                $('#downloadPdfLink').attr('href', downloadUrl);
                $('#prPreviewModal').modal('show');
            };

            window.printPreview = function() {
                const iframe = document.getElementById('prPreviewFrame');
                iframe.contentWindow.print();
            };
        });
    </script>

    <!-- PR Preview Modal -->
    <div class="modal fade" id="prPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 210mm; margin: 1.75rem auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Nota PR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0" style="width: 210mm; height: 297mm; overflow: auto;">
                    <iframe id="prPreviewFrame" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
                <div class="modal-footer">
                    <a href="#" id="downloadPdfLink" class="btn btn-success">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
