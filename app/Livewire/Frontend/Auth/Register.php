<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;

class Register extends Component
{
    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|max:255|unique:users,email')]
    public $email = '';

    #[Validate('required|string|min:8|confirmed')]
    public $password = '';

    // No validation rule needed here, 'confirmed' on $password checks this automatically
    public $password_confirmation = '';

    #[Validate('accepted', message: 'You must accept the terms and conditions.')]
    public $terms = false;

    public function register()
    {
        // 1. Validate inputs
        $this->validate();

        // 2. Create User
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // 3. Login the user
        Auth::login($user);

        // 4. Redirect to Home (or Dashboard)
        return $this->redirect(route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.frontend.auth.register');
    }
}
