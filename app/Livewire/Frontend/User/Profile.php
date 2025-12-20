<?php

namespace App\Livewire\Frontend\User;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $isEditing = false;

    // Form fields
    public $name, $email, $phone, $zip_code, $address;
    public $country_id, $state_id, $city_id;

    // Collections for dropdowns
    public $countries = [];
    public $states = [];
    public $cities = [];

    public function mount()
    {
        $user = Auth::user();

        // Initialize fields
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->zip_code = $user->zip_code;
        $this->address = $user->address;
        $this->country_id = $user->country_id;
        $this->state_id = $user->state_id;
        $this->city_id = $user->city_id;

        // Load initial lists
        $this->countries = Country::all();
        if ($this->country_id) {
            $this->states = State::where('country_id', $this->country_id)->get();
        }
        if ($this->state_id) {
            $this->cities = City::where('state_id', $this->state_id)->get();
        }
    }

    /**
     * Logic for dependent dropdowns
     */
    public function updatedCountryId($value)
    {
        $this->states = State::where('country_id', $value)->get();
        $this->cities = [];
        $this->state_id = null;
        $this->city_id = null;
    }

    public function updatedStateId($value)
    {
        $this->cities = City::where('state_id', $value)->get();
        $this->city_id = null;
    }

    public function toggleEdit()
    {
        $this->isEditing = !$this->isEditing;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'country_id' => 'nullable|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'city_id' => 'nullable|exists:cities,id',
            'zip_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        $this->isEditing = false;
        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.frontend.user.profile', [
            'user' => Auth::user()
        ]);
    }
}
