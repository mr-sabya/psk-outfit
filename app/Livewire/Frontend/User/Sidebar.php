<?php

namespace App\Livewire\Frontend\User;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Sidebar extends Component
{
    use WithFileUploads;

    public $photo;

    /**
     * This method runs automatically when $photo is updated (file selected)
     */
    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        $user = auth()->user();

        // Delete old avatar if it exists
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        // Store new avatar
        $path = $this->photo->store('avatars', 'public');

        // Update User Model
        $user->update([
            'avatar' => $path
        ]);

        session()->flash('message', 'Profile photo updated successfully.');
    }

    public function render()
    {
        return view('livewire.frontend.user.sidebar', [
            'user' => auth()->user()
        ]);
    }
}
