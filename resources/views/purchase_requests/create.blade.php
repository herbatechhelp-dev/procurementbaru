<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Purchase Request') }}
        </h2>
    </x-slot>

    <div class="pb-12 pt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('purchase-requests.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Main Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-medium mb-4">Request Details</h3>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="request_date" class="form-label">Request Date *</label>
                                <input type="date" class="form-control @error('request_date') is-invalid @enderror" id="request_date" name="request_date" value="{{ old('request_date', date('Y-m-d')) }}" required>
                                @error('request_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="purpose" class="form-label">Purpose of Request *</label>
                                <select class="form-control @error('purpose') is-invalid @enderror" id="purpose" name="purpose" required>
                                    <option value="">Select Purpose</option>
                                    @foreach($purposes as $purpose)
                                        <option value="{{ $purpose->name }}" {{ old('purpose') == $purpose->name ? 'selected' : '' }}>{{ $purpose->name }}</option>
                                    @endforeach
                                </select>
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
                            <!-- Items will be added here -->
                        </div>

                        @if($errors->has('items'))
                            <div class="alert alert-danger mt-3">
                                {{ $errors->first('items') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" name="action" value="submit" class="btn btn-primary">Submit Request</button>
                    <button type="submit" name="action" value="draft" class="btn btn-secondary">Save as Draft</button>
                    <a href="{{ route('purchase-requests.index') }}" class="btn btn-link text-gray-600">Cancel</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = 0;
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

            // Add rows from old input if validation failed, otherwise add one initial row
            const oldItems = @json(old('items'));
            if (oldItems && Object.keys(oldItems).length > 0) {
                Object.keys(oldItems).forEach(index => {
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
                });
            } else {
                container.insertAdjacentHTML('beforeend', createItemRow(itemIndex));
                itemIndex++;
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
