<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Purchase Request') }}
        </h2>
    </x-slot>

    <div class="pb-12 pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('purchase-requests.update', $purchaseRequest) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Main Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        @if($purchaseRequest->hasRejectedItems())
                            <div class="alert alert-warning mb-4">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Revision Required:</strong> Some items in this request were rejected. Please review the reasons below and update the items accordingly.
                            </div>
                        @endif
                        <h3 class="text-lg font-medium mb-4">Request Details</h3>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="request_date" class="form-label">Request Date *</label>
                                <input type="date" class="form-control @error('request_date') is-invalid @enderror" id="request_date" name="request_date" value="{{ old('request_date', $purchaseRequest->request_date->format('Y-m-d')) }}" required>
                                @error('request_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="purpose" class="form-label">Purpose of Request *</label>
                                @php
                                    $isRevision = str_contains($purchaseRequest->notes, 'Revision from');
                                @endphp
                                <select class="form-control @error('purpose') is-invalid @enderror" id="purpose" name="purpose" required {{ $isRevision ? 'disabled' : '' }}>
                                    <option value="">Select Purpose</option>
                                    @foreach($purposes as $purpose)
                                        <option value="{{ $purpose->name }}" {{ old('purpose', $purchaseRequest->purpose) == $purpose->name ? 'selected' : '' }}>{{ $purpose->name }}</option>
                                    @endforeach
                                </select>
                                @if($isRevision)
                                    <input type="hidden" name="purpose" value="{{ $purchaseRequest->purpose }}">
                                    <small class="text-muted">Purpose is locked for revisions.</small>
                                @endif
                                @error('purpose') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Items -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <div class="d-flex justify-content-between mb-4">
                            <h3 class="text-lg font-medium">Items</h3>
                            <button type="button" class="btn btn-success btn-sm" id="add-item">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>

                        <div id="items-container">
                            @php
                                $items = $purchaseRequest->items;
                                $lockedItems = $items->filter(function($item) use ($purchaseRequest) {
                                    $isRejected = str_starts_with($item->status, 'rejected');
                                    $isDraft = $purchaseRequest->status === 'draft';
                                    $isPending = $item->status === 'pending';
                                    return !($isRejected || $isDraft || ($isPending && $purchaseRequest->isEditable()));
                                });
                                $editableItems = $items->filter(function($item) use ($purchaseRequest) {
                                    $isRejected = str_starts_with($item->status, 'rejected');
                                    $isDraft = $purchaseRequest->status === 'draft';
                                    $isPending = $item->status === 'pending';
                                    return $isRejected || $isDraft || ($isPending && $purchaseRequest->isEditable());
                                });
                            @endphp

                            @if($lockedItems->isNotEmpty())
                                <div class="alert alert-info py-2 px-3 mb-4">
                                    <i class="fas fa-lock mr-1"></i> 
                                    <strong>Locked Items:</strong> Items below are already in the approval process and cannot be modified.
                                </div>
                                <div class="locked-items-section mb-5">
                                    @foreach($lockedItems as $item)
                                        @php $index = $items->search($item); @endphp
                                        <div class="card mb-3 bg-light border-light shadow-sm">
                                            <div class="card-body py-3">
                                                <div class="d-flex justify-content-between align-items-center mb-0">
                                                    <h6 class="mb-0 font-weight-bold">
                                                        <i class="fas fa-check-circle text-success mr-1"></i>
                                                        Item #{{ $index + 1 }}: {{ $item->item_name }}
                                                    </h6>
                                                    <span class="badge badge-info">
                                                        Status: {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                                    </span>
                                                </div>
                                                <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                                <input type="hidden" name="items[{{ $index }}][item_name]" value="{{ $item->item_name }}">
                                                <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}">
                                                <input type="hidden" name="items[{{ $index }}][uom]" value="{{ $item->uom }}">
                                                <input type="hidden" name="items[{{ $index }}][due_date]" value="{{ $item->due_date }}">
                                                <input type="hidden" name="items[{{ $index }}][description]" value="{{ $item->description }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr class="my-4">
                            @endif

                            @if($editableItems->isNotEmpty())
                                <h4 class="text-md font-bold mb-3 text-warning">
                                    <i class="fas fa-edit mr-1"></i> Items to Revise / Edit
                                </h4>
                                @foreach($editableItems as $item)
                                    @php 
                                        $index = $items->search($item);
                                        $isRejected = str_starts_with($item->status, 'rejected');
                                    @endphp
                                    <div class="card mb-3 item-row {{ $isRejected ? 'border-warning shadow-sm' : '' }}" id="item-row-{{ $index }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h5 class="card-title {{ $isRejected ? 'text-warning' : '' }} font-weight-bold">
                                                    Item #{{ $index + 1 }}
                                                    @if($isRejected)
                                                        <span class="badge badge-danger ml-2">Revision Required</span>
                                                    @endif
                                                </h5>
                                                <button type="button" class="btn btn-danger btn-xs remove-item" data-index="{{ $index }}">
                                                    <i class="fas fa-times"></i> Remove
                                                </button>
                                            </div>
                                            
                                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                            
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Item Name *</label>
                                                    <input type="text" name="items[{{ $index }}][item_name]" class="form-control" value="{{ old("items.{$index}.item_name", $item->item_name) }}" required>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Quantity *</label>
                                                    <input type="number" name="items[{{ $index }}][quantity]" class="form-control quantity-input" min="1" value="{{ old("items.{$index}.quantity", $item->quantity) }}" required>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">UOM *</label>
                                                    <select name="items[{{ $index }}][uom]" class="form-control" required>
                                                        @foreach($uoms as $uomOption)
                                                            <option value="{{ $uomOption->name }}" {{ $item->uom == $uomOption->name ? 'selected' : '' }}>{{ $uomOption->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Attachment / File</label>
                                                    @if($item->attachment)
                                                        <div class="mb-1">
                                                            <a href="{{ asset('storage/' . $item->attachment) }}" target="_blank" class="btn btn-xs btn-info">View Current</a>
                                                        </div>
                                                    @endif
                                                    <input type="file" name="items[{{ $index }}][attachment]" class="form-control">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Tgl Dibutuhkan / Keterangan</label>
                                                    <input type="text" name="items[{{ $index }}][due_date]" class="form-control" value="{{ old("items.{$index}.due_date", $item->due_date) }}" placeholder="Contoh: ASAP, 20 Jan, atau Segera">
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Description / Specs</label>
                                                    <textarea name="items[{{ $index }}][description]" class="form-control" rows="2">{{ old("items.{$index}.description", $item->description) }}</textarea>
                                                </div>

                                                @if($isRejected && $item->reject_reason)
                                                    <div class="col-md-12">
                                                        <div class="alert alert-danger py-2 px-3 mt-2">
                                                            <strong><i class="fas fa-times-circle"></i> Rejected:</strong> {{ $item->reject_reason }}
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        @if($errors->has('items'))
                            <div class="alert alert-danger mt-3">
                                {{ $errors->first('items') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" name="action" value="submit" class="btn btn-primary">Update and Submit</button>
                    <button type="submit" name="action" value="draft" class="btn btn-secondary">Save as Draft</button>
                    <a href="{{ route('purchase-requests.index') }}" class="btn btn-link text-gray-600">Cancel</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = {{ $purchaseRequest->items->count() }};
            const container = document.getElementById('items-container');
            const addButton = document.getElementById('add-item');

            function createItemRow(index) {
                const html = `
                    <div class="card mb-3 item-row" id="item-row-${index}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="card-title">Item #${index + 1}</h5>
                                <button type="button" class="btn btn-danger btn-xs remove-item" data-index="${index}">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Item Name *</label>
                                    <input type="text" name="items[${index}][item_name]" class="form-control" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Quantity *</label>
                                    <input type="number" name="items[${index}][quantity]" class="form-control quantity-input" min="1" required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">UOM *</label>
                                    <select name="items[${index}][uom]" class="form-control" required>
                                        <option value="">Select UOM</option>
                                        @foreach($uoms as $uom)
                                            <option value="{{ $uom->name }}">{{ $uom->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Attachment / File (Optional)</label>
                                    <input type="file" name="items[${index}][attachment]" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tgl Dibutuhkan / Keterangan</label>
                                    <input type="text" name="items[${index}][due_date]" class="form-control" placeholder="Contoh: ASAP, 20 Jan, atau Segera">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Description / Specs</label>
                                    <textarea name="items[${index}][description]" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                return html;
            }

            // Restore any new items that were added but failed validation
            const oldItems = @json(old('items'));
            if (oldItems) {
                Object.keys(oldItems).forEach(index => {
                    // If index is greater than or equal to original count, it's a newly added row
                    if (parseInt(index) >= {{ $purchaseRequest->items->count() }}) {
                        container.insertAdjacentHTML('beforeend', createItemRow(parseInt(index)));
                        const row = document.getElementById(`item-row-${index}`);
                        
                        // Fill in old values
                        row.querySelector(`[name="items[${index}][item_name]"]`).value = oldItems[index].item_name || '';
                        row.querySelector(`[name="items[${index}][quantity]"]`).value = oldItems[index].quantity || '';
                        row.querySelector(`[name="items[${index}][uom]"]`).value = oldItems[index].uom || '';
                        row.querySelector(`[name="items[${index}][due_date]"]`).value = oldItems[index].due_date || '';
                        row.querySelector(`[name="items[${index}][description]"]`).value = oldItems[index].description || '';
                        
                        if (parseInt(index) >= itemIndex) {
                            itemIndex = parseInt(index) + 1;
                        }
                    }
                });
            }

            addButton.addEventListener('click', function() {
                container.insertAdjacentHTML('beforeend', createItemRow(itemIndex));
                itemIndex++;
            });

            container.addEventListener('click', function(e) {
                if (e.target.closest('.remove-item')) {
                    const row = e.target.closest('.item-row');
                    const allRows = container.querySelectorAll('.item-row');
                    if (allRows.length > 1) {
                        row.remove();
                    } else {
                        alert('At least one item is required.');
                    }
                }
            });
        });
    </script>
</x-app-layout>
