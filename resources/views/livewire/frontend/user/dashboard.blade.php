<div class="dashboard_content mt_100">
    <div class="row">
        <!-- Total Order -->
        <div class="col-xl-4 col-md-6 wow fadeInUp">
            <div class="dashboard_overview_item">
                <div class="icon">
                    <i class="fas fa-shopping-basket"></i>
                </div>
                <h3> {{ $totalOrders }} <span>Total Order</span></h3>
            </div>
        </div>
        <!-- Completed Order -->
        <div class="col-xl-4 col-md-6 wow fadeInUp">
            <div class="dashboard_overview_item blue">
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3> {{ $completedOrders }} <span>Completed Order</span></h3>
            </div>
        </div>
        <!-- Pending Order -->
        <div class="col-xl-4 col-md-6 wow fadeInUp">
            <div class="dashboard_overview_item orange">
                <div class="icon">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <h3> {{ $pendingOrders }} <span>Pending Order</span></h3>
            </div>
        </div>
        <!-- Canceled Order -->
        <div class="col-xl-4 col-md-6 wow fadeInUp">
            <div class="dashboard_overview_item red">
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h3> {{ $canceledOrders }} <span>Canceled Order</span></h3>
            </div>
        </div>
        <!-- Wishlist -->
        <div class="col-xl-4 col-md-6 wow fadeInUp">
            <div class="dashboard_overview_item purple">
                <div class="icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3> {{ $wishlistCount }} <span>Total Wishlist</span></h3>
            </div>
        </div>
        <!-- Reviews -->
        <div class="col-xl-4 col-md-6 wow fadeInUp">
            <div class="dashboard_overview_item olive">
                <div class="icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3> {{ $reviewCount }} <span>Total Reviews</span></h3>
            </div>
        </div>
    </div>

    <div class="row mt_25">
        <!-- Recent Orders Table -->
        <div class="col-xl-7 wow fadeInLeft">
            <div class="dashboard_recent_order">
                <h3>Your Recent order</h3>
                <div class="dashboard_order_table">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->order_number ?? $order->id }}</td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="{{ $order->status }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                    <td>
                                        <a href="#">
                                            <i class="far fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">No orders found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reviews List -->
        <div class="col-xl-5 wow fadeInRight">
            <div class="dashboard_recent_review">
                <h3>Your Recent Reviews</h3>
                <div class="single_review_list_area">
                    @forelse($recentReviews as $review)
                    <div class="single_review">
                        <div class="text">
                            <h5>
                                <a class="title" href="{{ route('product.show', $review->product->slug) }}">
                                    {{ $review->product->name }}
                                </a>
                                <span>
                                    @for($i=1; $i<=5; $i++)
                                        <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                </span>
                            </h5>
                            <p class="date">{{ $review->created_at->format('d F Y') }}</p>
                            <p class="description">{{ Str::limit($review->comment, 100) }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <p class="text-muted">You haven't submitted any reviews yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>