<?php

namespace App\Livewire\Frontend\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function updatePassword()
    {
        // 1. Validation
        $this->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'], // confirmed checks for 'new_password_confirmation'
        ]);

        $user = Auth::user();

        // 2. Check if current password matches
        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The provided password does not match your current password.');
            return;
        }

        // 3. Update Password
        $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        // 4. Reset form fields and notify user
        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('success', 'Password updated successfully!');
    }

    public function render()
    {
        return view('livewire.frontend.user.password');
    }
}
