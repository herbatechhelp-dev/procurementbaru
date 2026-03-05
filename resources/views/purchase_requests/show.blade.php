<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             PR #{{ $purchaseRequest->pr_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            


            <!-- Header Info -->
            <div class="card shadow-sm rounded-lg mb-6">
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
            <div class="card shadow-sm rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-lg font-medium">Items List</h3>
                        @if($purchaseRequest->hasRejectedItems() && (Auth::id() == $purchaseRequest->user_id || Auth::user()->hasRole('superadmin')))
                            <form action="{{ route('purchase-requests.revise-item', $purchaseRequest->items->whereIn('status', ['rejected_om', 'rejected_gm', 'rejected_proc'])->first()) }}" method="POST" class="form-confirm" data-message="Revise all rejected items? They will be moved to a new PR for revision.">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm shadow-sm">
                                    <i class="fas fa-sync-alt mr-1"></i> Revise All Rejected Items
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless">
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
                                                $omApproval = $item->approvals->where('approver_role', 'operational_manager')->whereIn('status', ['approved', 'rejected'])->sortByDesc('created_at')->first();
                                                $gmApproval = $item->approvals->where('approver_role', 'general_manager')->whereIn('status', ['approved', 'rejected'])->sortByDesc('created_at')->first();
                                                $procApproval = $item->approvals->where('approver_role', 'procurement')->where('status', 'approved')->first();
                                                $validationNotes = $item->approvals
                                                    ->where('status', 'pending')
                                                    ->filter(function($approval) {
                                                        return !empty($approval->notes);
                                                    })
                                                    ->sortByDesc('created_at');
                                            @endphp

                                            @if($omApproval) 
                                                <div class="{{ $omApproval->status == 'approved' ? 'text-success' : 'text-danger' }}">
                                                    OM: {{ $omApproval->status == 'approved' ? 'Approve' : 'Reject' }} ({{ $omApproval->approved_at->format('d/m/y H:i') }})
                                                    @if($omApproval->purchase_request_id != $purchaseRequest->id) <span class="text-muted small font-italic">(Revised)</span> @endif
                                                </div> 
                                                @if($omApproval->notes)
                                                    <div class="text-muted">Catatan OM: {{ $omApproval->notes }}</div>
                                                @endif
                                            @endif
                                            @if($gmApproval) 
                                                <div class="{{ $gmApproval->status == 'approved' ? 'text-success' : 'text-danger' }}">
                                                    GM: {{ $gmApproval->status == 'approved' ? 'Approve' : 'Reject' }} ({{ $gmApproval->approved_at->format('d/m/y H:i') }})
                                                    @if($gmApproval->purchase_request_id != $purchaseRequest->id) <span class="text-muted small font-italic">(Revised)</span> @endif
                                                </div> 
                                                @if($gmApproval->notes)
                                                    <div class="text-muted">Catatan GM: {{ $gmApproval->notes }}</div>
                                                @endif
                                            @endif
                                            @if($procApproval) 
                                                <div class="text-success">
                                                    Proc: Approve ({{ $procApproval->approved_at->format('d/m/y H:i') }})
                                                    @if($procApproval->purchase_request_id != $purchaseRequest->id) <span class="text-muted small font-italic">(Revised)</span> @endif
                                                </div> 
                                                @if($procApproval->notes)
                                                    <div class="text-muted">Catatan Proc: {{ $procApproval->notes }}</div>
                                                @endif
                                            @endif
                                            
                                            @if($item->rejected_at) <div class="text-danger">Rejected: {{ $item->rejected_at->format('d/m/y H:i') }}</div> @endif
                                            @if($item->processed_at) <div class="text-info">Ready to Process: {{ $item->processed_at->format('d/m/y H:i') }}</div> @endif
                                            @if($item->ordered_at) <div class="text-primary">Ordered: {{ $item->ordered_at->format('d/m/y H:i') }}</div> @endif
                                            @if($item->delivered_at) <div class="text-primary">Delivered: {{ $item->delivered_at->format('d/m/y H:i') }}</div> @endif
                                            @if($item->completed_at) <div class="text-success">Completed: {{ $item->completed_at->format('d/m/y H:i') }}</div> @endif

                                            @if($validationNotes->isNotEmpty())
                                                <div class="mt-3 chat-notes-container">
                                                    <div class="text-xs text-muted mb-2 border-bottom pb-1"><i class="fas fa-comments mr-1"></i> Validation Notes</div>
                                                    @foreach($validationNotes as $note)
                                                        <div class="chat-bubble {{ $note->approver_id == Auth::id() ? 'chat-right' : 'chat-left' }}">
                                                            <div class="chat-header">
                                                                <span class="chat-name">{{ $note->approver->name ?? strtoupper(str_replace('_', ' ', $note->approver_role)) }}</span>
                                                                <span class="chat-time">{{ $note->created_at->format('d/m H:i') }}</span>
                                                            </div>
                                                            <div class="chat-body">
                                                                {{ $note->notes }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="min-width: 120px;">
                                        <!-- Approval/Rejection Actions -->
                                        @php
                                            $canApprove = false;
                                            $canSendNote = false;
                                            $role = Auth::user()->getRoleNames()->first();
                                            $isOm = Auth::user()->hasRole('operational_manager');
                                            $isGm = Auth::user()->hasRole('general_manager');
                                            $isProc = Auth::user()->hasRole('procurement');
                                            $isSuperadmin = Auth::user()->hasRole('superadmin');
                                            
                                            if ($purchaseRequest->status !== 'draft') {
                                                if ($isOm && $item->status == 'pending') { $canApprove = true; $canSendNote = true; }
                                                if ($isGm && $item->status == 'approved_om') { $canApprove = true; $canSendNote = true; }
                                                if ($isProc && $item->status == 'approved_gm') { $canApprove = true; $canSendNote = true; }
                                                if ($isSuperadmin && in_array($item->status, ['pending', 'approved_om', 'approved_gm'])) { $canApprove = true; $canSendNote = true; }
                                                if ($purchaseRequest->user_id == Auth::id()) { $canSendNote = true; }
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
                                        @if($canSendNote)
                                            <button type="button" class="btn btn-primary btn-xs mt-1" data-toggle="modal" data-target="#noteModal-{{ $item->id }}">
                                                Send Note / Reply
                                            </button>
                                        @endif

                                        <!-- Procurement Status Update -->
                                        @if(($isProc || $isSuperadmin) && in_array($item->status, ['approved_gm', 'approved_proc', 'ordered', 'delivered', 'completed']))
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
                                            <div class="modal-content" style="background-color: #222630; color: #f8fafc; border: 1px solid rgba(255,255,255,0.1); border-radius: 15px;">
                                                <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                                    <h5 class="modal-title">Approve Item: {{ $item->item_name }}</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="text-gray-300">Notes (Optional)</label>
                                                        <textarea name="notes" class="form-control" style="background-color: #1a1d24; border: 1px solid rgba(255,255,255,0.1); color: white;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.05);">
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
                                            <div class="modal-content" style="background-color: #222630; color: #f8fafc; border: 1px solid rgba(255,255,255,0.1); border-radius: 15px;">
                                                <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                                    <h5 class="modal-title">Reject Item: {{ $item->item_name }}</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="text-gray-300">Catatan Validasi / Reason for Rejection *</label>
                                                        <textarea name="reject_reason" class="form-control" required style="background-color: #1a1d24; border: 1px solid rgba(255,255,255,0.1); color: white;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.05);">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-danger">Confirm Reject</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Send Note Modal -->
                                <div class="modal fade" id="noteModal-{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <form action="{{ route('purchase-requests.send-note', $item) }}" method="POST">
                                            @csrf
                                            <div class="modal-content" style="background-color: #222630; color: #f8fafc; border: 1px solid rgba(255,255,255,0.1); border-radius: 15px;">
                                                <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                                                    <h5 class="modal-title">Kirim Catatan Validasi: {{ $item->item_name }}</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label class="text-gray-300">Notes ke requester *</label>
                                                        <textarea name="notes" class="form-control" required style="background-color: #1a1d24; border: 1px solid rgba(255,255,255,0.1); color: white;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.05);">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Kirim Note</button>
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
    <style>
        @media (max-width: 768px) {
            .mobile-modal-dialog {
                margin: 0.5rem;
                max-width: calc(100% - 1rem) !important;
            }

            .mobile-modal-content {
                max-height: calc(100vh - 1rem);
            }

            .mobile-modal-body {
                max-height: calc(100vh - 140px);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .mobile-safe-footer {
                padding-bottom: calc(0.75rem + env(safe-area-inset-bottom));
            }

            .pr-preview-body {
                width: 100% !important;
                height: calc(100vh - 220px) !important;
            }

            @supports (-webkit-touch-callout: none) {
                .mobile-modal-content {
                    max-height: -webkit-fill-available;
                }

                .mobile-modal-body {
                    max-height: calc(100dvh - 140px);
                }

                .pr-preview-body {
                    height: calc(100dvh - 220px) !important;
                }
            }
        }

        /* Chat Notes Styles */
        .chat-notes-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-height: 250px;
            overflow-y: auto;
            padding-right: 5px;
        }
        
        .chat-bubble {
            max-width: 85%;
            padding: 8px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            position: relative;
            line-height: 1.3;
        }

        .chat-left {
            align-self: flex-start;
            background-color: #2c313c; /* Dark Grey for others */
            color: #e0e6ed;
            border-bottom-left-radius: 2px;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .chat-right {
            align-self: flex-end;
            background-color: #1e3a8a; /* Blue Primary tinted for self */
            color: #ffffff;
            border-bottom-right-radius: 2px;
            border: 1px solid rgba(37,99,235,0.3);
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3px;
        }

        .chat-name {
            font-weight: 600;
            font-size: 0.65rem;
            color: inherit;
            opacity: 0.8;
        }

        .chat-time {
            font-size: 0.6rem;
            color: inherit;
            opacity: 0.6;
            margin-left: 8px;
        }

        .chat-body {
            word-wrap: break-word;
        }
    </style>

    <!-- Preview Modal -->
    <div class="modal fade" id="attachmentPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable mobile-modal-dialog" role="document">
            <div class="modal-content mobile-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewFilename">File Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 mobile-modal-body" id="previewBody">
                    <!-- Preview content will be injected here -->
                    <div class="text-center p-5 loading-spinner">
                        <i class="fas fa-spinner fa-spin fa-3x"></i>
                    </div>
                </div>
                <div class="modal-footer mobile-safe-footer">
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
            $('[id^="approveModal-"], [id^="rejectModal-"], [id^="noteModal-"], #attachmentPreviewModal, #prPreviewModal').each(function() {
                if (this.parentNode !== document.body) {
                    document.body.appendChild(this);
                }
            });

            $(document).on('shown.bs.modal', '.modal', function () {
                $(this).css('padding-right', '0');
                $('body').addClass('modal-open');
            });

            $('.preview-attachment').on('click', function(e) {
                e.preventDefault();
                const url = $(this).data('url');
                const filename = $(this).data('filename');
                const extension = filename.split('.').pop().toLowerCase();
                
                $('#previewFilename').text(filename);
                $('#downloadLink').attr('href', url);
                $('#previewBody').html('<div class="text-center p-5"><i class="fas fa-spinner fa-spin fa-3x"></i></div>');
                
                const $attachmentModal = $('#attachmentPreviewModal');
                if (!$attachmentModal.parent().is('body')) {
                    $attachmentModal.appendTo('body');
                }

                $attachmentModal.modal('show');
                
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

                const $prModal = $('#prPreviewModal');
                if (!$prModal.parent().is('body')) {
                    $prModal.appendTo('body');
                }

                $prModal.modal('show');
            };

            window.printPreview = function() {
                const iframe = document.getElementById('prPreviewFrame');
                iframe.contentWindow.print();
            };
        });
    </script>

    <!-- PR Preview Modal -->
    <div class="modal fade" id="prPreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable mobile-modal-dialog" role="document" style="max-width: 210mm; margin: 1.75rem auto;">
            <div class="modal-content mobile-modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Nota PR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 mobile-modal-body pr-preview-body" style="width: 210mm; height: 297mm; overflow: auto;">
                    <iframe id="prPreviewFrame" style="width: 100%; height: 100%; border: none;"></iframe>
                </div>
                <div class="modal-footer mobile-safe-footer">
                    <a href="#" id="downloadPdfLink" class="btn btn-success">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
