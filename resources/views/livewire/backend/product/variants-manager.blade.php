<div class="">

    <!-- FLASH MESSAGES SECTION -->
    @if (session()->has('message'))
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-3">
        <i class="fas fa-check-circle me-2"></i>
        <div>{{ session('message') }}</div>
    </div>
    @endif



    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Manage Variants for "{{ $product->name }}"</h3>
    </div>
    <div class="row">
        <!-- STEP 1: ATTRIBUTE SELECTION -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold text-dark">Step 1: Create New Variants</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($allAttributes as $attribute)
                        <div class="col-md-3 mb-3">
                            <label class="fw-bold text-muted small text-uppercase">{{ $attribute->name }}</label>
                            <div class="border rounded p-2 bg-light mt-1" style="max-height: 160px; overflow-y: auto;">
                                @foreach($attribute->values as $val)
                                <div class="form-check custom-checkbox">
                                    <input class="form-check-input" type="checkbox"
                                        wire:model="selectedValues.{{ $attribute->id }}.{{ $val->id }}"
                                        id="val-{{ $val->id }}">
                                    <label class="form-check-label" for="val-{{ $val->id }}">{{ $val->value }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-2 text-end">
                        <button class="btn btn-primary px-4 shadow-sm" wire:click="generateVariants">
                            <i class="fas fa-layer-group me-1"></i> Generate Variant Rows
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- STEP 2: VARIANT LIST -->
        <div class="col-12">

            @if (session()->has('error'))
            <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-3">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div class="fw-bold text-danger">{{ session('error') }}</div>
            </div>
            @endif
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0 fw-bold text-dark">Step 2: Manage Variant List</h6>
                    @if(count($variants) > 0)
                    <button class="btn btn-success fw-bold px-4 shadow-sm" wire:click="save">
                        <i class="fas fa-save me-1"></i> SAVE ALL CHANGES
                    </button>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-muted small text-uppercase">
                                <tr>
                                    <th class="ps-4">Combination</th>
                                    <th>SKU</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th class="text-center">Active Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($variants as $index => $v)
                                <tr wire:key="row-{{ $index }}" class="{{ !$v['is_active'] ? 'bg-light opacity-75' : '' }}">
                                    <td class="ps-4">
                                        <span class="fw-bold {{ $v['is_active'] ? 'text-dark' : 'text-muted text-decoration-line-through' }}">
                                            {{ $v['name'] }}
                                        </span>
                                        @if(!$v['is_saved'])
                                        <span class="badge bg-warning text-dark ms-2 small">New</span>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model="variants.{{ $index }}.sku" placeholder="SKU">
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" wire:model="variants.{{ $index }}.price">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm"
                                            wire:model="variants.{{ $index }}.quantity">
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-inline-block">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                wire:model="variants.{{ $index }}.is_active">
                                            <small class="d-block text-muted">
                                                {{ $v['is_active'] ? 'Active' : 'Hidden' }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-danger border-0"
                                            wire:click="deleteVariant({{ $index }})"
                                            wire:confirm="This variant will be permanently removed from the database. Are you sure?">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                        No variants found. Select values above and click "Generate Rows".
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-checkbox .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .table-light {
            background-color: #f8f9fa !important;
        }

        .opacity-75 {
            opacity: 0.7;
        }
    </style>
</div>