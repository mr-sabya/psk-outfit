<div class="dashboard_content mt_100">
    <h3 class="dashboard_title">
        {{ $address_id ? 'Edit' : 'Add New' }} Address
        <a class="common_btn cancel_edit" href="{{ route('user.address') }}" wire:navigate>cancel</a>
    </h3>

    <div class="address_add_area dashboard_profile_info_edit">
        <form wire:submit.prevent="saveAddress">
            <div class="row">
                <!-- Name Row -->
                <div class="col-md-6">
                    <div class="single_input">
                        <label>First Name *</label>
                        <input type="text" wire:model="first_name" placeholder="John">
                        @error('first_name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single_input">
                        <label>Last Name *</label>
                        <input type="text" wire:model="last_name" placeholder="Doe">
                        @error('last_name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Contact Row -->
                <div class="col-md-6">
                    <div class="single_input">
                        <label>Email *</label>
                        <input type="email" wire:model="email" placeholder="example@mail.com">
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single_input">
                        <label>Phone *</label>
                        <input type="text" wire:model="phone" placeholder="+123456789">
                        @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="single_input">
                        <label>Company Name (Optional)</label>
                        <input type="text" wire:model="company_name" placeholder="Company Ltd.">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="single_input">
                        <label>Address Type</label>
                        <select wire:model="type" class="form-select form-control">
                            <option value="shipping">Shipping Address</option>
                            <option value="billing">Billing Address</option>
                            <option value="both">Both</option>
                        </select>
                    </div>
                </div>

                <!-- Location Selects -->
                <div class="col-md-4">
                    <div class="single_input">
                        <label>Country *</label>
                        <select wire:model.live="country_id" class="form-select form-control">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('country_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="single_input">
                        <label>State *</label>
                        <select wire:model.live="state_id" class="form-select form-control" {{ empty($states) ? 'disabled' : '' }}>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                        @error('state_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="single_input">
                        <label>City *</label>
                        <select wire:model.live="city_id" class="form-select form-control" {{ empty($cities) ? 'disabled' : '' }}>
                            <option value="">Select City</option>
                            @foreach($cities as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('city_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Address Row -->
                <div class="col-md-8">
                    <div class="single_input">
                        <label>Street Address *</label>
                        <input type="text" wire:model="address_line_1" placeholder="House 12, Road 5...">
                        @error('address_line_1') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single_input">
                        <label>Zip Code *</label>
                        <input type="text" wire:model="zip_code" placeholder="1234">
                        @error('zip_code') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="single_input">
                        <label>Apartment, suite, unit, etc. (optional)</label>
                        <input type="text" wire:model="address_line_2" placeholder="Floor 3, Apt 4B">
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="form-check">
                        <input class="form-check-input p-0" type="checkbox" wire:model="is_default" id="isDefault">
                        <label class="form-check-label" for="isDefault">
                            Set as default shipping/billing address
                        </label>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="common_btn" wire:loading.attr="disabled">
                        <span wire:loading.remove>save address <i class="fas fa-long-arrow-right"></i></span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>