<?php

namespace App\Livewire\Frontend\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Logout extends Component
{
    public $spanActive = false;

    public function mount($spanActive = false)
    {
        $this->spanActive = $spanActive;
    }

    public function logout()
    {
        Auth::logout();
        return $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.frontend.auth.logout');
    }
}
