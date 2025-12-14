<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    public $remember = false;

    public function login()
    {
        // 1. Validate inputs based on attributes above
        $this->validate();

        // 2. Attempt to authenticate
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            // Add error to the 'email' field if auth fails
            $this->addError('email', trans('auth.failed'));
            return;
        }

        // 3. Regenerate session ID (Security best practice)
        session()->regenerate();

        // 4. Redirect to the intended page (or home if none)
        // 'navigate: true' enables SPA-like transition
        return $this->redirectIntended(default: route('home'), navigate: true);
    }

    public function render()
    {
        return view('livewire.frontend.auth.login');
    }
}
