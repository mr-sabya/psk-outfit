<?php

namespace App\Livewire\Backend\Cache;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class Manager extends Component
{
    public function clearCache($type)
    {
        // 1. Security Check (Adjust logic to your auth system)
        if (!Auth::user()?->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        // 2. Map actions to Artisan commands
        $commands = [
            'all'    => 'optimize:clear',
            'config' => 'config:clear',
            'cache'  => 'cache:clear',
            'view'   => 'view:clear',
            'route'  => 'route:clear',
        ];

        if (array_key_exists($type, $commands)) {
            Artisan::call($commands[$type]);

            session()->flash('success', "Success: {$commands[$type]} executed!");
        }
    }

    public function render()
    {
        return view('livewire.backend.cache.manager');
    }
}
