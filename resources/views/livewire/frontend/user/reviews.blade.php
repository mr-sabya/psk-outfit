<div class="dashboard_content mt_100">
    <h3 class="dashboard_title">My Reviews</h3>
    <div class="dashboard_reviews">
        <div class="single_review_list_area">

            @forelse($reviews as $review)
            <div class="single_review" style="margin-bottom: 30px;">
                <div class="img">
                    <!-- Assuming your product has an image field -->
                    <img src="{{ $review->product->thumbnail_url }}"
                        alt="{{ $review->product->name }}"
                        class="img-fluid w-100">
                </div>
                <div class="text">
                    <h5>
                        <a class="title" href="{{ route('product.show', $review->product->slug ?? $review->product->id) }}">
                            {{ $review->product->name }}
                        </a>
                        <span>
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star" aria-hidden="true"></i>
                                @endfor
                        </span>
                    </h5>

                    <div class="d-flex align-items-center gap-3">
                        <p class="date">{{ $review->created_at->format('d F Y') }}</p>

                        <!-- Status Badge: Helpful for users to know if their review is public yet -->
                        @php
                        $statusColor = match($review->status->value ?? $review->status) {
                        'approved' => 'text-success',
                        'pending' => 'text-warning',
                        'rejected' => 'text-danger',
                        default => 'text-muted'
                        };
                        @endphp
                        <small class="{{ $statusColor }} fw-bold" style="text-transform: capitalize;">
                            ({{ $review->status->label() }})
                        </small>
                    </div>

                    <p class="description">{{ $review->comment }}</p>
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <p>You haven't written any reviews yet.</p>
                <a href="/" class="btn btn-primary">Start Shopping</a>
            </div>
            @endforelse

        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="pagination_area">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>