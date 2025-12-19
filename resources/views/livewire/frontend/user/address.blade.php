<div class="dashboard_content mt_100">
    <h3 class="dashboard_title">Address List
        <a class="common_btn" href="{{ route('user.address.create') }}" wire:navigate>Add New</a>
    </h3>

    @if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="dashboard_addredd_list">
        <div class="checkout_address_area">
            <div class="row">
                @forelse($addresses as $address)
                <div class="col-md-6 mb-4">
                    <div class="checkout_single_address {{ $address->is_default ? 'border-primary' : '' }}" style="position: relative; border: 1px solid #eee; padding: 20px; border-radius: 8px;">

                        @if($address->is_default)
                        <span class="badge bg-primary" style="position: absolute; top: 10px; right: 10px;">Default</span>
                        @endif

                        <label class="form-check-label w-100">
                            <!-- Address Details -->
                            <span class="d-block mb-2">
                                <b style="color: #ff3c00;">{{ $address->first_name }} {{ $address->last_name }}</b>
                            </span>

                            <span class="d-flex align-items-start mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; margin-right: 10px; margin-top: 3px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"></path>
                                </svg>
                                {{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->state }} {{ $address->zip_code }}, {{ $address->country }}
                            </span>

                            <span class="d-flex align-items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; margin-right: 10px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z"></path>
                                </svg>
                                {{ $address->email }}
                            </span>

                            <span class="d-flex align-items-center mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 18px; margin-right: 10px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 3.75 18 6m0 0 2.25 2.25M18 6l2.25-2.25M18 6l-2.25 2.25m1.5 13.5c-8.284 0-15-6.716-15-15V4.5A2.25 2.25 0 0 1 4.5 2.25h1.372c.516 0 .966.351 1.091.852l1.106 4.423c.11.44-.054.902-.417 1.173l-1.293.97a1.062 1.062 0 0 0-.38 1.21 12.035 12.035 0 0 0 7.143 7.143c.441.162.928-.004 1.21-.38l.97-1.293a1.125 1.125 0 0 1 1.173-.417l4.423 1.106c.5.125.852.575.852 1.091V19.5a2.25 2.25 0 0 1-2.25 2.25h-2.25Z"></path>
                                </svg>
                                {{ $address->phone }}
                            </span>
                        </label>

                        <!-- Actions -->
                        <div class="address_actions d-flex mt-3 pt-3 border-top">
                            @if(!$address->is_default)
                            <button wire:click="setDefault({{ $address->id }})" class="btn btn-sm btn-outline-secondary me-2">Set Default</button>
                            @endif
                            <a href="{{ route('user.address.edit', $address->id) }}" wire:navigate class="btn btn-sm btn-outline-info me-2">Edit</a>
                            <button
                                wire:click="deleteAddress({{ $address->id }})"
                                wire:confirm="Are you sure you want to delete this address?"
                                class="btn btn-sm btn-outline-danger">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p>You haven't added any addresses yet.</p>
                    <a href="{{ route('user.address.create') }}" wire:navigate class="common_btn">Add First Address</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>