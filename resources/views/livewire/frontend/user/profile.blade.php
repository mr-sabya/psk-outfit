<div class="dashboard_content mt_100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="dashboard_title">Profile Information</h3>
        <button wire:click="toggleEdit" class="common_btn">
            {{ $isEditing ? 'Cancel' : 'Edit Profile' }}
        </button>
    </div>

    @if (session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (!$isEditing)
    {{-- VIEW MODE --}}
    <div class="dashboard_profile_info_list">
        <ul>
            <li><span>Name:</span> {{ $user->name }}</li>
            <li><span>Email:</span> {{ $user->email }}</li>
            <li><span>Phone:</span> {{ $user->phone ?? 'N/A' }}</li>
            <li><span>Country:</span> {{ $user->country?->name ?? 'N/A' }}</li>
            <li><span>State:</span> {{ $user->state?->name ?? 'N/A' }}</li>
            <li><span>City:</span> {{ $user->city?->name ?? 'N/A' }}</li>
            <li><span>Zip:</span> {{ $user->zip_code ?? 'N/A' }}</li>
            <li><span>Address:</span> {{ $user->address ?? 'N/A' }}</li>
        </ul>
    </div>
    @else
    {{-- EDIT MODE --}}
    <form wire:submit.prevent="updateProfile" class="dashboard_profile_edit_form">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" wire:model="name" class="form-control">
                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" wire:model="email" class="form-control">
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="text" wire:model="phone" class="form-control">
                @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Country</label>
                <select wire:model.live="country_id" class="form-control">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>State</label>
                <select wire:model.live="state_id" class="form-control" {{ empty($states) ? 'disabled' : '' }}>
                    <option value="">Select State</option>
                    @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>City</label>
                <select wire:model="city_id" class="form-control" {{ empty($cities) ? 'disabled' : '' }}>
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Zip Code</label>
                <input type="text" wire:model="zip_code" class="form-control">
            </div>
            <div class="col-md-12 mb-3">
                <label>Address</label>
                <textarea wire:model="address" class="form-control" rows="3"></textarea>
            </div>
            <div class="col-12 mt-3">
                <button type="submit" class="common_btn">
                    <span wire:loading.remove wire:target="updateProfile">Update Information</span>
                    <span wire:loading wire:target="updateProfile">Saving...</span>
                </button>
            </div>
        </div>
    </form>
    @endif
</div>