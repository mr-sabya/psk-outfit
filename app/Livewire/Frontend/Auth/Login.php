<?php

namespace App\Livewire\Frontend\Auth;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Login extends Component
{
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required')]
    public $password = '';

    public $remember = false;

    public function mount()
    {
        /** 
         * Capture the actual page the user came from.
         * We check:
         * 1. If 'url.intended' is already set (don't overwrite middleware redirects).
         * 2. If the previous URL is not the login page itself.
         * 3. If the previous URL is not an internal Livewire update path.
         */
        $previousUrl = url()->previous();
        $loginUrl = route('login');

        if (!Session::has('url.intended')) {
            if ($previousUrl !== $loginUrl && !str_contains($previousUrl, '/livewire/update')) {
                Session::put('url.intended', $previousUrl);
            }
        }
    }

    public function login()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));
            return;
        }

        // Before regenerating, grab the intended URL from session
        $redirectUrl = Session::get('url.intended', route('home'));

        // Security: Regenerate session to prevent session fixation
        Session::regenerate();

        // Use redirect() instead of redirectIntended to ensure 'navigate: true' works
        // and manually pass the URL we captured.
        return $this->redirect($redirectUrl, navigate: true);
    }

    public function render()
    {
        return view('livewire.frontend.auth.login');
    }
}
