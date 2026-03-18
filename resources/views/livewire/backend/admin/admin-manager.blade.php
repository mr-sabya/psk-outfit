<div class="py-4">
    <h2 class="mb-4">Admin Management</h2>

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Administrators List</h5>
            <button class="btn btn-primary" wire:click="createAdmin">
                <i class="fas fa-plus"></i> Add New Admin
            </button>
        </div>
        <div class="card-body">
            <div class="row align-items-center mb-3">
                <div class="col-md-6 col-lg-4">
                    <input type="text" class="form-control" placeholder="Search admins..." wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-md-6 col-lg-8 d-flex justify-content-md-end justify-content-start mt-2 mt-md-0">
                    <div class="d-flex align-items-center gap-2">
                        <select wire:model.live="perPage" class="form-select w-auto">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span class="text-nowrap">Per Page</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('id')" role="button" style="width: 80px;">ID
                                @if ($sortField == 'id') <i class="fas {{ $sortDirection == 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i> @endif
                            </th>
                            <th wire:click="sortBy('name')" role="button">Name
                                @if ($sortField == 'name') <i class="fas {{ $sortDirection == 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i> @endif
                            </th>
                            <th wire:click="sortBy('email')" role="button">Email
                                @if ($sortField == 'email') <i class="fas {{ $sortDirection == 'asc' ? 'fa-sort-up' : 'fa-sort-down' }}"></i> @endif
                            </th>
                            <th>Created At</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                        <tr>
                            <td>{{ $admin->id }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->created_at->format('M d, Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-info me-1" wire:click="editAdmin({{ $admin->id }})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" wire:click="deleteAdmin({{ $admin->id }})" wire:confirm="Are you sure you want to delete this administrator?" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No admins found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $admins->links() }}
            </div>
        </div>
    </div>

    <!-- Admin Create/Edit Modal -->
    <div class="modal fade {{ $showModal ? 'show d-block' : '' }}" id="adminModal" tabindex="-1" role="dialog" @if($showModal) style="background-color: rgba(0,0,0,.5);" @endif>
        <div class="modal-dialog" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">{{ $isEditing ? 'Edit Admin' : 'Add New Admin' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <form wire:submit.prevent="saveAdmin">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model.defer="name">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model.defer="email">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Password
                                @if($isEditing) <span class="text-muted">(Leave blank to keep current)</span> @else <span class="text-danger">*</span> @endif
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model.defer="password">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" wire:model.defer="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading wire:target="saveAdmin" class="spinner-border spinner-border-sm"></span>
                            {{ $isEditing ? 'Update Admin' : 'Create Admin' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>