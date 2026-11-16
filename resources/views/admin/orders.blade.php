@extends('admin.layout')

@section('title', 'Customer Orders & Payments')
@section('page_title', 'Customer Orders & Indian Transactions')

@section('content')

<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
    <div class="p-3 bg-light border-bottom d-flex justify-content-between align-items-center">
        <span class="small text-muted fw-bold text-uppercase">
            <i class="fa-solid fa-indian-rupee-sign text-primary me-1"></i> Recorded Transactions & Orders ({{ $orders->total() }})
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="bg-light text-muted text-uppercase">
                <tr>
                    <th>Order No</th>
                    <th>Customer & Address</th>
                    <th>Book</th>
                    <th>Amount (₹)</th>
                    <th>Payment Mode</th>
                    <th>Transaction ID</th>
                    <th>Status Update</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong class="text-dark">#{{ $order->order_number }}</strong>
                            <div class="text-muted" style="font-size:11px;">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                        </td>
                        <td>
                            <strong class="text-dark d-block">{{ $order->customer_name }}</strong>
                            <div class="text-muted small">{{ $order->shipping_address }}, {{ $order->city }} - {{ $order->pincode }}</div>
                            <div class="text-muted small"><i class="fa-solid fa-phone me-1"></i> +91 {{ $order->customer_phone }}</div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($order->book)
                                    <img src="{{ $order->book->image }}" alt="" class="rounded" style="width: 32px; height: 42px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 140px;">{{ $order->book->title }}</div>
                                        <span class="badge bg-light text-dark border">{{ $order->book->condition ?? 'Good' }}</span>
                                    </div>
                                @else
                                    <span class="text-muted">Deleted Book</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <strong class="text-primary fs-6">₹{{ number_format($order->amount, 0) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary text-uppercase">
                                {{ str_replace('_', ' ', $order->payment_method) }}
                            </span>
                        </td>
                        <td>
                            <code class="text-dark small">{{ $order->transaction_id }}</code>
                        </td>
                        <td>
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="d-flex align-items-center gap-1">
                                @csrf
                                <select name="delivery_status" class="form-select form-select-sm" style="min-width: 140px;">
                                    <option value="Order Placed" {{ $order->delivery_status === 'Order Placed' ? 'selected' : '' }}>Order Placed</option>
                                    <option value="Packaging" {{ $order->delivery_status === 'Packaging' ? 'selected' : '' }}>Packaging</option>
                                    <option value="In Transit" {{ $order->delivery_status === 'In Transit' ? 'selected' : '' }}>In Transit</option>
                                    <option value="Delivered" {{ $order->delivery_status === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                </select>
                                <input type="hidden" name="payment_status" value="completed">
                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Update Status">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
