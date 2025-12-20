<div class="dashboard_content mt_100">
    <h3 class="dashboard_title">Order History</h3>

    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

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
                    @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>
                            @php
                            $status = $order->order_status->value ?? $order->order_status;
                            $statusClass = match($status) {
                            'completed', 'delivered' => 'complete',
                            'pending', 'processing', 'shipped' => 'active',
                            'cancelled' => 'cancel',
                            default => 'active',
                            };
                            @endphp
                            <span class="{{ $statusClass }}">
                                {{ str($status)->headline() }}
                            </span>
                        </td>
                        <td>{{ $order->currency }} {{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <div>
                                {{-- View Button --}}
                                <a href="{{ route('user.orders.show', $order->order_number) }}" wire:navigate>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    View
                                </a>

                                {{-- Show Cancel button only if pending --}}
                                @if($status === 'pending')
                                <a href="javascript:void(0)"
                                    wire:click="openCancelModal({{ $order->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                    Cancel
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>

    {{-- CANCEL MODAL --}}
    @if($showCancelModal)
    <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5); z-index: 1050;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Order</h5>
                    <button type="button" class="btn-close" wire:click="closeCancelModal"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted">Please provide a reason for cancelling this order.</p>
                    <div class="form-group">
                        <textarea wire:model="cancelReason" class="form-control" rows="4" placeholder="e.g. I ordered the wrong item..."></textarea>
                        @error('cancelReason') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeCancelModal">Close</button>
                    <button type="button" class="btn btn-danger" wire:click="confirmCancel">
                        <span wire:loading.remove wire:target="confirmCancel" class="text-white">Confirm Cancellation</span>
                        <span wire:loading wire:target="confirmCancel" class="text-white">Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>