<?php

namespace App\Livewire\Frontend\User;

use App\Models\Address as ModelsAddress;
use Livewire\Component;
use App\Models\Address as userAdress;
use Illuminate\Support\Facades\Auth;

class Address extends Component
{
    public function render()
    {
        $addresses = userAdress::where('user_id', Auth::id())
            ->orderBy('is_default', 'desc')
            ->latest()
            ->get();

        return view('livewire.frontend.user.address', [
            'addresses' => $addresses
        ]);
    }

    public function deleteAddress($id)
    {
        $address = userAdress::where('user_id', Auth::id())->findOrFail($id);
        $address->delete();

        session()->flash('message', 'Address deleted successfully.');
    }

    public function setDefault($id)
    {
        // Remove default from all other addresses of this user
        userAdress::where('user_id', Auth::id())->update(['is_default' => false]);

        // Set this one as default
        userAdress::where('user_id', Auth::id())->where('id', $id)->update(['is_default' => true]);

        session()->flash('message', 'Default address updated.');
    }
}
