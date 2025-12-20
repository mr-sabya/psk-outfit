<?php

namespace App\Livewire\Frontend\User;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Reviews extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // Fetch reviews for the logged-in user, eager loading the product
        $reviews = Review::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(5);

        return view('livewire.frontend.user.reviews', [
            'reviews' => $reviews
        ]);
    }
}
