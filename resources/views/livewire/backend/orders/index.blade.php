<div class="py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Order Management</h2>
    </div>

    @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Order #, TxID, Customer, Vendor..." wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-md-8 text-md-end mt-2 mt-md-0">
                    <select wire:model.live="perPage" class="form-select w-auto d-inline-block">
                        <option value="10">10 Per Page</option>
                        <option value="25">25 Per Page</option>
                        <option value="50">50 Per Page</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th wire:click="sortBy('order_number')" style="cursor:pointer">Order #</th>
                            <th>Customer</th>
                            <th>Vendor</th> <!-- Added Vendor Column -->
                            <th>Payment Info</th> <!-- Added Method & TxID Column -->
                            <th wire:click="sortBy('total_amount')" style="cursor:pointer">Amount</th>
                            <th>Status</th>
                            <th wire:click="sortBy('placed_at')" style="cursor:pointer">Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td class="fw-bold text-primary">{{ $order->order_number }}</td>
                            <td>
                                <div>{{ $order->user->name ?? 'Guest' }}</div>
                                <small class="text-muted">{{ $order->billing_phone }}</small>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    <i class="fas fa-store me-1"></i> {{ $order->vendor->name ?? 'System' }}
                                </span>
                            </td>
                            <td>
                                <div class="small fw-bold">{{ $order->payment_method_name }}</div>
                                @if($order->transaction_id)
                                <code class="text-danger small">{{ $order->transaction_id }}</code>
                                @else
                                <small class="text-muted italic">No TxID</small>
                                @endif
                            </td>
                            <td>৳{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $order->order_status->badgeColor() }} d-block mb-1">
                                    Order: {{ $order->order_status->label() }}
                                </span>
                                <span class="badge {{ $order->payment_status->badgeColor() }} d-block">
                                    Payment: {{ $order->payment_status->label() }}
                                </span>
                            </td>
                            <td class="small">{{ $order->placed_at?->format('d M, Y h:i A') }}</td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary" wire:click="viewOrderDetails({{ $order->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-dark" wire:click="openStatusUpdateModal({{ $order->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-file-invoice"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">No orders found matching your criteria.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $orders->links() }}
        </div>
    </div>

    {{-- Order Details Modal --}}
    <div class="modal fade" id="order-details-modal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeOrderDetailsModal"></button>
                </div>
                <div class="modal-body">
                    @if ($showOrderDetailsModal && $selectedOrderId)
                    {{-- Here we'll embed the OrderDetails component --}}
                    {{-- This is a pattern for dynamic component loading within a modal --}}
                    <livewire:backend.orders.manage :orderId="$selectedOrderId" wire:key="order-{{ $selectedOrderId }}" />
                    @else
                    <p>Select an order to view details.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeOrderDetailsModal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Order Status Update Modal --}}
    <div class="modal fade" id="status-update-modal" tabindex="-1" aria-labelledby="statusUpdateModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusUpdateModalLabel">Update Order Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeStatusUpdateModal"></button>
                </div>
                <form wire:submit.prevent="updateOrderStatus">
                    <div class="modal-body">
                        @if ($updateOrderId)
                        <div class="mb-3">
                            <label for="newOrderStatus" class="form-label">Order Status</label>
                            <select class="form-select @error('newOrderStatus') is-invalid @enderror" id="newOrderStatus" wire:model.defer="newOrderStatus">
                                @foreach($orderStatuses as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                @endforeach
                            </select>
                            @error('newOrderStatus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newPaymentStatus" class="form-label">Payment Status</label>
                            <select class="form-select @error('newPaymentStatus') is-invalid @enderror" id="newPaymentStatus" wire:model.defer="newPaymentStatus">
                                @foreach($paymentStatuses as $status)
                                <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                @endforeach
                            </select>
                            @error('newPaymentStatus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        @else
                        <p>No order selected for status update.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeStatusUpdateModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading wire:target="updateOrderStatus" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        // Order Details Modal
        const orderDetailsModalElement = document.getElementById('order-details-modal');
        const orderDetailsModal = new bootstrap.Modal(orderDetailsModalElement);

        Livewire.on('open-order-details-modal', () => {
            orderDetailsModal.show();
        });

        Livewire.on('close-order-details-modal', () => {
            orderDetailsModal.hide();
        });

        // Order Status Update Modal
        const statusUpdateModalElement = document.getElementById('status-update-modal');
        const statusUpdateModal = new bootstrap.Modal(statusUpdateModalElement);

        Livewire.on('open-status-update-modal', () => {
            statusUpdateModal.show();
        });

        Livewire.on('close-status-update-modal', () => {
            statusUpdateModal.hide();
        });
    });
</script>