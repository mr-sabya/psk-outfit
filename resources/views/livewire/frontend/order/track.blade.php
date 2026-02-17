<section class="order_track_page mt_100 mb_100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="track_search_box border p-4 rounded bg-white shadow-sm mb-5">
                    <h4 class="mb-3 text-center">Track Your Order</h4>
                    <p class="text-center text-muted small mb-4">Enter your order number to check current status.</p>

                    <form wire:submit.prevent="trackOrder" class="d-flex gap-2">
                        <input type="text" wire:model.defer="orderNumber" class="form-control" placeholder="e.g. #ABC1234567">
                        <button type="submit" class="common_btn px-4" style="padding: 10px 25px;">Track</button>
                    </form>
                    @error('orderNumber') <span class="text-danger small">{{ $message }}</span> @enderror

                    @if($notFound)
                    <div class="alert alert-warning mt-3 small text-center">
                        Order not found. Please check the ID and try again.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($order)
        <div class="row justify-content-center wow fadeInUp">
            <div class="col-lg-10">
                <div class="order_summary_header d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                    <div>
                        <h5 class="mb-0">Order ID: <span class="text-danger">{{ $order->order_number }}</span></h5>
                        <p class="mb-0 text-muted small">Placed on: {{ $order->placed_at ? $order->placed_at->format('d M, Y') : $order->created_at->format('d M, Y') }}</p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : 'primary' }} text-uppercase px-3 py-2">
                            {{ $order->order_status }}
                        </span>
                    </div>
                </div>

                <!-- Progress Tracker Timeline -->
                <div class="track_timeline mb-5 mt-5">
                    <div class="d-flex justify-content-between position-relative">
                        <div class="progress_line"></div>

                        <!-- Step 1: Pending -->
                        <div class="track_step {{ in_array($order->order_status, ['pending', 'processing', 'shipped', 'delivered']) ? 'active' : '' }}">
                            <div class="step_icon"><i class="fal fa-file-alt"></i></div>
                            <p>Pending</p>
                        </div>

                        <!-- Step 2: Processing -->
                        <div class="track_step {{ in_array($order->order_status, ['processing', 'shipped', 'delivered']) ? 'active' : '' }}">
                            <div class="step_icon"><i class="fal fa-cog"></i></div>
                            <p>Processing</p>
                        </div>

                        <!-- Step 3: Shipped -->
                        <div class="track_step {{ in_array($order->order_status, ['shipped', 'delivered']) ? 'active' : '' }}">
                            <div class="step_icon"><i class="fal fa-truck"></i></div>
                            <p>Shipped</p>
                        </div>

                        <!-- Step 4: Delivered -->
                        <div class="track_step {{ $order->order_status == 'delivered' ? 'active' : '' }}">
                            <div class="step_icon"><i class="fal fa-check-circle"></i></div>
                            <p>Delivered</p>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-7">
                        <div class="table-responsive border rounded">
                            <table class="table mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">Product</th>
                                        <th>Qty</th>
                                        <th class="text-end pe-3">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                    <tr>
                                        <td class="ps-3 py-3">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product->thumbnail_url }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded border me-3">
                                                <span>{{ Str::limit($item->item_name, 40) }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end pe-3">৳{{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="p-4 border rounded bg-white h-100">
                            <h6 class="fw-bold mb-3 border-bottom pb-2">Order Details</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Payment:</span>
                                <span>{{ $order->payment_method_name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Shipping:</span>
                                <span>{{ $order->shipping_method_name }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-2 fw-bold">
                                <span>Total Amount:</span>
                                <span class="text-danger">৳{{ number_format($order->total_amount, 2) }}</span>
                            </div>

                            <h6 class="fw-bold mt-4 mb-3 border-bottom pb-2">Shipping Address</h6>
                            <p class="small text-muted mb-0">
                                {{ $order->shipping_first_name }}<br>
                                {{ $order->shipping_address_line_1 }}<br>
                                {{ $order->shipping_phone }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>


    <style>
        /* Tracking Timeline CSS */
        .track_timeline {
            position: relative;
        }

        .progress_line {
            position: absolute;
            top: 25px;
            left: 5%;
            right: 5%;
            height: 4px;
            background: #eee;
            z-index: 1;
        }

        .track_step {
            text-align: center;
            z-index: 2;
            width: 20%;
        }

        .step_icon {
            width: 50px;
            height: 50px;
            background: #fff;
            border: 2px solid #eee;
            border-radius: 50%;
            line-height: 46px;
            margin: 0 auto 10px;
            font-size: 20px;
            color: #bbb;
            transition: 0.3s;
        }

        .track_step.active .step_icon {
            background: #ff3c00;
            border-color: #ff3c00;
            color: #fff;
        }

        .track_step p {
            font-weight: 600;
            color: #999;
            font-size: 14px;
        }

        .track_step.active p {
            color: #ff3c00;
        }
    </style>

</section>