<div>
    @if (session()->has('message'))
    <div class="alert alert-success border-0 shadow-sm mb-4">
        {{ session('message') }}
    </div>
    @endif

    <div class="row">
        <!-- Main Order Details -->
        <div class="col-lg-8">
            <!-- Order Info Header -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Order #{{ $order->order_number }}</h4>
                        <div>
                            <span class="badge {{ $order->order_status->badgeColor() }} p-2">{{ $order->order_status->label() }}</span>
                            <span class="badge {{ $order->payment_status->badgeColor() }} p-2">{{ $order->payment_status->label() }}</span>
                        </div>
                    </div>
                    <p class="text-muted mb-0">Placed on: {{ $order->placed_at?->format('d M, Y h:i A') }}</p>
                </div>
            </div>

            <!-- Items Table -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-shopping-basket me-2"></i> Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item->product->thumbnail_url }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-3">
                                            <div>
                                                <div class="fw-bold">{{ $item->item_name }}</div>
                                                <small class="text-muted">SKU: {{ $item->item_sku }}</small>
                                                @if($item->item_attributes)
                                                <div class="mt-1">
                                                    @foreach($item->item_attributes as $key => $val)
                                                    <span class="badge bg-light text-dark border">{{ $key }}: {{ $val }}</span>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>৳{{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end">৳{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                    <td class="text-end">৳{{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Shipping:</td>
                                    <td class="text-end">৳{{ number_format($order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr class="fs-5">
                                    <td colspan="3" class="text-end fw-bold text-primary">Grand Total:</td>
                                    <td class="text-end fw-bold text-primary">৳{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Addresses -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white"><strong>Shipping Address</strong></div>
                        <div class="card-body">
                            <p class="mb-1"><strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong></p>
                            <p class="mb-1">{{ $order->shipping_address_line_1 }}</p>
                            <p class="mb-1">{{ $order->shippingCity?->name }}, {{ $order->shippingState?->name }}</p>
                            <p class="mb-1">{{ $order->shippingCountry?->name }}, {{ $order->shipping_zip_code }}</p>
                            <p class="mb-0"><i class="fas fa-phone me-2"></i> {{ $order->shipping_phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-white"><strong>Billing Address</strong></div>
                        <div class="card-body">
                            <p class="mb-1"><strong>{{ $order->billing_first_name }} {{ $order->billing_last_name }}</strong></p>
                            <p class="mb-1">{{ $order->billing_address_line_1 }}</p>
                            <p class="mb-0"><i class="fas fa-envelope me-2"></i> {{ $order->billing_email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- Payment Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i> Payment Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small d-block">Method</label>
                        <span class="fw-bold">{{ $order->payment_method_name }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Transaction ID</label>
                        @if($order->transaction_id)
                        <code class="fs-6 text-danger">{{ $order->transaction_id }}</code>
                        @else
                        <span class="text-muted italic">N/A</span>
                        @endif
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small d-block">Vendor Responsible</label>
                        <span class="badge bg-dark">{{ $order->vendor->name ?? 'System' }}</span>
                    </div>
                </div>
            </div>

            <!-- Management Form -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">Update Order</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="updateOrder">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Order Status</label>
                            <select class="form-select" wire:model="orderStatus">
                                @foreach($orderStatuses as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Payment Status</label>
                            <select class="form-select" wire:model="paymentStatus">
                                @foreach($paymentStatuses as $pStatus)
                                <option value="{{ $pStatus->value }}">{{ $pStatus->label() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Tracking Number</label>
                            <input type="text" class="form-control" wire:model="trackingNumber" placeholder="e.g. DH123456">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fas fa-save me-2"></i> Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>