<div class="shop_details_review">
    <div class="single_review_list_area">
        <h3>Customer Reviews ({{ $reviews->count() }})</h3>

        @foreach($reviews as $review)
        <div class="single_review" style="margin-bottom: 20px; border-bottom: 1px solid #eee;">
            <div class="img">
                <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : asset('assets/frontend/images/dashboard_user_img.jpg') }}" alt="Reviews" class="img-fluid w-100">
            </div>
            <div class="text">
                <h5>{{ $review->user->name }}
                    <span>
                        @for($i=1; $i<=5; $i++)
                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star" style="color: #ffb400;"></i>
                            @endfor
                    </span>
                </h5>
                <p class="date">{{ $review->created_at->format('d M Y') }}</p>
                <p class="description">{{ $review->comment }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Review Form Section -->
    <div class="review_form_area mt-5">
        @auth
        @if(auth()->user()->hasPurchased($product->id))
        <h4>Leave a Review</h4>

        @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form wire:submit.prevent="store">
            <div class="form-group mb-3">
                <label>Rating</label>
                <select wire:model="rating" class="form-control">
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Good</option>
                    <option value="3">3 - Average</option>
                    <option value="2">2 - Poor</option>
                    <option value="1">1 - Terrible</option>
                </select>
                @error('rating') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Your Comment</label>
                <textarea wire:model="comment" class="form-control" rows="4" placeholder="Write your experience..."></textarea>
                @error('comment') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
        @else
        <div class="alert alert-info">
            Only customers who have purchased this product can leave a review.
        </div>
        @endif
        @else
        <div class="alert alert-info">
            Please <a href="{{ route('login') }}">login</a> to write a review.
        </div>
        @endauth
    </div>
</div>