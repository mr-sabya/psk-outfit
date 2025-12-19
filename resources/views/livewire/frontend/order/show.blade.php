<div class="dashboard_content mt_100">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="dashboard_title">Order Details</h3>
        <a href="{{ route('user.orders') }}" class="btn btn-sm btn-secondary">Back to List</a>
    </div>

    <div class="row">
        {{-- Order Info Header --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <p class="mb-0 text-muted">Order Number</p>
                        <h4 class="fw-bold">#{{ $order->order_number }}</h4>
                    </div>
                    <div>
                        <p class="mb-0 text-muted">Placed On</p>
                        <h5 class="mb-0">{{ $order->created_at->format('M d, Y') }}</h5>
                    </div>
                    <div>
                        <p class="mb-0 text-muted">Status</p>
                        <span class="badge {{ $order->order_status->value == 'completed' ? 'bg-success' : 'bg-primary' }}">
                            {{ strtoupper($order->order_status->value) }}
                        </span>
                    </div>
                    <div>
                        <p class="mb-0 text-muted">Total Amount</p>
                        <h4 class="mb-0 text-success">{{ $order->currency }} {{ number_format($order->total_amount, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Items Table --}}
        <div class="col-lg-8">
            <div class="dashboard_order_table bg-white p-4 rounded shadow-sm">
                <h5 class="mb-3">Items Order</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        {{-- If you have a Product model with an image, use it here --}}
                                        <div style="width: 60px; height: 60px; margin-right: 15px;">
                                            <img src="{{ $item->product->thumbnail_url ?? 'https://via.placeholder.com/60' }}"
                                                alt="{{ $item->item_name }}"
                                                class="rounded">
                                        </div>
                                        <div>
                                            <p class="mb-0 fw-bold">{{ $item->item_name }}</p>
                                            <small class="text-muted">{{ $item->getFormattedAttributesAttribute() }}</small>
                                            <br><small class="text-muted">SKU: {{ $item->item_sku }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $order->currency }} {{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end fw-bold">{{ $order->currency }} {{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12 ms-auto">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td>Subtotal</td>
                                <td class="text-end">{{ $order->currency }} {{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Shipping ({{ $order->shipping_method_name }})</td>
                                <td class="text-end">{{ $order->currency }} {{ number_format($order->shipping_cost, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td class="text-end">{{ $order->currency }} {{ number_format($order->tax_amount, 2) }}</td>
                            </tr>
                            @if($order->discount_amount > 0)
                            <tr>
                                <td class="text-danger">Discount</td>
                                <td class="text-danger text-end">- {{ $order->currency }} {{ number_format($order->discount_amount, 2) }}</td>
                            </tr>
                            @endif
                            <tr class="border-top">
                                <td class="fw-bold">Grand Total</td>
                                <td class="text-end fw-bold text-primary" style="font-size: 1.2rem;">
                                    {{ $order->currency }} {{ number_format($order->total_amount, 2) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Shipping & Payment Details Sidebar --}}
        <div class="col-lg-4">
            {{-- Shipping Address --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Shipping Address</h5>
                    <p class="mb-1 fw-bold">{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</p>
                    <p class="mb-1 text-muted small"><i class="fas fa-envelope me-2"></i>{{ $order->shipping_email }}</p>
                    <p class="mb-1 text-muted small"><i class="fas fa-phone me-2"></i>{{ $order->shipping_phone }}</p>
                    <hr>
                    <p class="mb-0 small text-muted">
                        {{ $order->getFullShippingAddressAttribute() }}
                    </p>
                </div>
            </div>

            {{-- Payment Info --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Payment Info</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Method:</span>
                        <span class="fw-bold">{{ $order->payment_method_name }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Status:</span>
                        <span class="badge bg-{{ $order->payment_status->value == 'paid' ? 'success' : 'warning' }}">
                            {{ strtoupper($order->payment_status->value) }}
                        </span>
                    </div>
                    @if($order->transaction_id)
                    <div class="small text-muted mt-2 text-center border-top pt-2">
                        Trans. ID: {{ $order->transaction_id }}
                    </div>
                    @endif
                </div>
            </div>

            @if($order->notes)
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-2">Order Notes</h5>
                    <p class="small text-muted mb-0 italic">"{{ $order->notes }}"</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>