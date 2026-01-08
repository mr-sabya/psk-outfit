<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends Component
{
    #[Validate('required|email')]
    public $email = '';

    public $status = '';

    public function sendResetLink()
    {
        $this->validate();

        // Send the password reset link
        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            $this->status = trans($status);
            $this->reset('email');
        } else {
            $this->addError('email', trans($status));
        }
    }

    public function render()
    {
        return view('livewire.frontend.auth.forgot-password');
    }
}
