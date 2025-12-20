<?php

namespace App\Livewire\Frontend\Product;

use Livewire\Component;
use App\Models\Review as ReviewModel;
use App\Enums\ReviewStatus;
use Illuminate\Support\Facades\Auth;

class Review extends Component
{
    public $product;
    public $rating = 5;
    public $comment;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:5|max:500',
    ];

    public function mount($product)
    {
        $this->product = $product;
    }

    public function store()
    {
        if (!Auth::check()) {
            return session()->flash('error', 'You must be logged in to post a review.');
        }

        // Security check: Ensure user purchased the product
        if (!Auth::user()->hasPurchased($this->product->id)) {
            return session()->flash('error', 'You can only review products you have purchased.');
        }

        // Check if user already reviewed this product
        $alreadyReviewed = ReviewModel::where('user_id', Auth::id())
            ->where('product_id', $this->product->id)
            ->exists();

        if ($alreadyReviewed) {
            return session()->flash('error', 'You have already reviewed this product.');
        }

        $this->validate();

        ReviewModel::create([
            'user_id' => Auth::id(),
            'product_id' => $this->product->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'status' => ReviewStatus::Pending, // New reviews usually start as pending
        ]);

        $this->reset(['rating', 'comment']);
        session()->flash('success', 'Review submitted successfully! It will appear once approved.');
    }

    public function render()
    {
        // Load approved reviews to display
        $reviews = $this->product->reviews()->where('status', ReviewStatus::Approved)->latest()->get();

        return view('livewire.frontend.product.review', [
            'reviews' => $reviews
        ]);
    }
}
