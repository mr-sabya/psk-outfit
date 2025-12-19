<?php

namespace App\Livewire\Frontend\User;

use App\Models\Address;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AddressManage extends Component
{
    public $address_id; // Present if editing

    // Model Fields
    public $first_name, $last_name, $company_name, $email, $phone;
    public $country_id, $state_id, $city_id;
    public $address_line_1, $address_line_2, $zip_code;
    public $type = 'shipping'; // Default value
    public $is_default = false;

    // Collections
    public $states = [];
    public $cities = [];

    public function mount($id = null)
    {
        if ($id) {
            $this->address_id = $id;
            $address = Address::where('user_id', Auth::id())->findOrFail($id);

            $this->first_name = $address->first_name;
            $this->last_name = $address->last_name;
            $this->company_name = $address->company_name;
            $this->email = $address->email;
            $this->phone = $address->phone;
            $this->country_id = $address->country_id;
            $this->state_id = $address->state_id;
            $this->city_id = $address->city_id;
            $this->address_line_1 = $address->address_line_1;
            $this->address_line_2 = $address->address_line_2;
            $this->zip_code = $address->zip_code;
            $this->type = $address->type;
            $this->is_default = $address->is_default;

            // Load existing dependencies
            $this->states = State::where('country_id', $this->country_id)->get();
            $this->cities = City::where('state_id', $this->state_id)->get();
        }
    }

    public function updatedCountryId($value)
    {
        $this->states = State::where('country_id', $value)->get();
        $this->state_id = null;
        $this->cities = [];
        $this->city_id = null;
    }

    public function updatedStateId($value)
    {
        $this->cities = City::where('state_id', $value)->get();
        $this->city_id = null;
    }

    public function saveAddress()
    {
        $data = $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'address_line_1' => 'required',
            'address_line_2' => 'nullable',
            'zip_code' => 'required',
            'type' => 'required|in:shipping,billing,both', 
            'is_default' => 'boolean',
        ]);

        if ($this->is_default) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        Address::updateOrCreate(
            ['id' => $this->address_id, 'user_id' => Auth::id()],
            $data
        );

        session()->flash('message', 'Address saved successfully.');
        return redirect()->route('user.address');
    }

    public function render()
    {
        return view('livewire.frontend.user.address-manage', [
            'countries' => Country::all()
        ]);
    }
}
