<div class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Shipping Management</h3>
        <button wire:click="openMethodModal" class="btn btn-primary">Add New Method</button>
    </div>

    @if (session()->has('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" wire:model.live="search" class="form-control" placeholder="Search methods...">
                </div>
                <div class="col-md-3">
                    <select wire:model.live="statusFilter" class="form-select">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select wire:model.live="perPage" class="form-select">
                        <option value="10">10 Per Page</option>
                        <option value="25">25 Per Page</option>
                        <option value="50">50 Per Page</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Methods Table -->
    <div class="table-responsive bg-white shadow-sm rounded">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="cursor:pointer" wire:click="sortBy('name')">
                        Method Name @if($sortField === 'name') <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i> @endif
                    </th>
                    <th>Rules (Location & Cost)</th>
                    <th style="cursor:pointer" wire:click="sortBy('is_default')">Default</th>
                    <th style="cursor:pointer" wire:click="sortBy('status')">Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($methods as $method)
                <tr>
                    <td>
                        <strong>{{ $method->name }}</strong><br>
                        <small class="text-muted">{{ $method->slug }}</small>
                    </td>
                    <td>
                        @foreach($method->rules as $rule)
                        <div class="badge bg-light text-dark border mb-1 d-flex justify-content-between align-items-center" style="font-weight: 400;">
                            <span>
                                {{ $rule->city?->name ?? $rule->state?->name ?? $rule->country->name }}:
                                <strong>৳{{ $rule->cost }}</strong>
                            </span>
                            <div class="ms-2">
                                <button wire:click="openRuleModal({{ $method->id }}, {{ $rule->id }})" class="btn btn-sm p-0 text-info"><i class="fas fa-edit"></i></button>
                                <button wire:click="deleteRule({{ $rule->id }})" wire:confirm="Delete this rule?" class="btn btn-sm p-0 text-danger"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        @endforeach
                        <button wire:click="openRuleModal({{ $method->id }})" class="btn btn-sm btn-outline-primary d-block mt-1">+ Add Rule</button>
                    </td>
                    <td>
                        @if($method->is_default)
                        <span class="badge bg-success">Default</span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:click="toggleStatus({{ $method->id }})" {{ $method->status ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td class="text-end">
                        <button wire:click="openMethodModal({{ $method->id }})" class="btn btn-sm btn-info text-white"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4">No shipping methods found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $methods->links() }}
    </div>

    <!-- Method Modal -->
    @if($showMethodModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5)">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $method_id ? 'Edit' : 'Add' }} Shipping Method</h5>
                    <button wire:click="$set('showMethodModal', false)" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Method Name</label>
                        <input type="text" wire:model="name" class="form-control">
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" wire:model="is_default" class="form-check-input" id="def">
                        <label for="def">Set as Default Method</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" wire:model="status" class="form-check-input" id="sta">
                        <label for="sta">Active</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="saveMethod" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Rule Modal -->
    @if($showRuleModal)
    <div class="modal fade show d-block" style="background: rgba(0,0,0,0.5)">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Shipping Rule for {{ App\Models\ShippingMethod::find($selected_method_id)->name }}</h5>
                    <button wire:click="$set('showRuleModal', false)" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Country</label>
                        <select wire:model.live="country_id" class="form-select">
                            <option value="">Select Country</option>
                            @foreach($countries as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>State (Optional - Leave blank for all states)</label>
                        <select wire:model.live="state_id" class="form-select" {{ empty($states) ? 'disabled' : '' }}>
                            <option value="">All States</option>
                            @foreach($states as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>City (Optional - Leave blank for all cities)</label>
                        <select wire:model.live="city_id" class="form-select" {{ empty($cities) ? 'disabled' : '' }}>
                            <option value="">All Cities</option>
                            @foreach($cities as $ct) <option value="{{ $ct->id }}">{{ $ct->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Shipping Cost (৳)</label>
                        <input type="number" wire:model="cost" class="form-control" step="0.01">
                        @error('cost') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="saveRule" class="btn btn-primary">Save Rule</button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>