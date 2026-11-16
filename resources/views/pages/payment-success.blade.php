@extends('layouts.app')

@section('title', 'Payment Successful - Order Confirmed #' . $order->order_number)

@section('content')

<section class="py-5 bg-light min-vh-100">
    <div class="container max-w-800">
        <!-- Success Alert Header -->
        <div class="text-center mb-4">
            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center shadow-lg mb-3" style="width: 72px; height: 72px; font-size: 32px;">
                <i class="fa-solid fa-check"></i>
            </div>
            <h1 class="display-6 fw-bold text-dark mb-1">Payment Successful!</h1>
            <p class="text-muted">Your book order has been confirmed and dispatched for packaging.</p>
        </div>

        <!-- Receipt Card -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white mb-4" id="printableReceipt">
            <!-- Receipt Header -->
            <div class="p-4 bg-dark text-white d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <span class="text-info small text-uppercase fw-bold letter-spacing-1">Payment Receipt & Invoice</span>
                    <h4 class="mb-0 fw-bold">Order #{{ $order->order_number }}</h4>
                </div>
                <div class="text-md-end">
                    <span class="badge bg-success px-3 py-2 rounded-pill fs-6">
                        <i class="fa-solid fa-circle-check me-1"></i> Paid in Full (INR)
                    </span>
                </div>
            </div>

            <!-- Receipt Body -->
            <div class="p-4 p-md-5">
                <!-- Meta Info Grid -->
                <div class="row g-3 p-3 rounded-3 bg-light border mb-4">
                    <div class="col-sm-6 col-md-3">
                        <span class="small text-muted d-block text-uppercase fw-semibold">Order Date</span>
                        <strong class="text-dark">{{ $order->created_at->format('M d, Y') }}</strong>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <span class="small text-muted d-block text-uppercase fw-semibold">Transaction ID</span>
                        <strong class="text-dark small text-break">{{ $order->transaction_id }}</strong>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <span class="small text-muted d-block text-uppercase fw-semibold">Payment Mode</span>
                        <span class="badge bg-primary text-white text-uppercase">
                            {{ str_replace('_', ' ', $order->payment_method) }}
                        </span>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <span class="small text-muted d-block text-uppercase fw-semibold">Total Amount</span>
                        <strong class="text-primary fs-5">₹{{ number_format($order->amount, 0) }}</strong>
                    </div>
                </div>

                <!-- Book Purchased Preview -->
                <h6 class="fw-bold text-dark text-uppercase small mb-3">Item Details</h6>
                <div class="d-flex align-items-center gap-3 p-3 border rounded-3 mb-4">
                    <img src="{{ $order->book->image }}" alt="{{ $order->book->title }}" class="rounded shadow-sm" style="width: 60px; height: 80px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="fw-bold text-dark mb-1">{{ $order->book->title }}</h6>
                        <div class="small text-muted">Author: {{ $order->book->author }} • Condition: <span class="badge bg-light text-dark border">{{ $order->book->condition ?? 'Good' }}</span></div>
                    </div>
                    <div class="text-end">
                        <span class="fs-5 fw-bold text-primary">₹{{ number_format($order->amount, 0) }}</span>
                    </div>
                </div>

                <!-- Shipping Destination -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-dark text-uppercase small mb-2">Delivery Address</h6>
                        <div class="p-3 bg-light rounded-3 border small text-muted">
                            <strong class="text-dark d-block fs-6 mb-1">{{ $order->customer_name }}</strong>
                            <div>{{ $order->shipping_address }}</div>
                            <div>{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</div>
                            <div class="mt-2"><i class="fa-solid fa-phone me-1"></i> +91 {{ $order->customer_phone }}</div>
                            <div><i class="fa-solid fa-envelope me-1"></i> {{ $order->customer_email }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold text-dark text-uppercase small mb-2">Estimated Delivery Timeline</h6>
                        <div class="p-3 bg-light rounded-3 border small">
                            <div class="d-flex align-items-center gap-2 text-success fw-bold mb-2">
                                <i class="fa-solid fa-truck-fast fs-5"></i>
                                <span>Arriving within 3 to 5 business days</span>
                            </div>
                            <p class="text-muted mb-0">
                                Tracking details and courier consignment numbers will be dispatched to your phone number via WhatsApp and SMS.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Delivery Tracker Steps -->
                <div class="border-top pt-4">
                    <h6 class="fw-bold text-dark text-uppercase small mb-3">Order Status</h6>
                    <div class="d-flex justify-content-between align-items-center position-relative text-center">
                        <div class="z-1">
                            <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                                <i class="fa-solid fa-check small"></i>
                            </div>
                            <div class="small fw-bold text-dark mt-1">Confirmed</div>
                        </div>
                        <div class="z-1">
                            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                                <i class="fa-solid fa-box-archive small"></i>
                            </div>
                            <div class="small fw-bold text-primary mt-1">Packaging</div>
                        </div>
                        <div class="z-1">
                            <div class="rounded-circle bg-light text-muted border d-inline-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                                <i class="fa-solid fa-truck small"></i>
                            </div>
                            <div class="small text-muted mt-1">In Transit</div>
                        </div>
                        <div class="z-1">
                            <div class="rounded-circle bg-light text-muted border d-inline-flex align-items-center justify-content-center" style="width:32px; height:32px;">
                                <i class="fa-solid fa-house-chimney small"></i>
                            </div>
                            <div class="small text-muted mt-1">Delivered</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons (Non-printable) -->
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <button type="button" class="btn btn-outline-dark px-4 py-2" onclick="window.print()">
                <i class="fa-solid fa-print me-2"></i> Print / Save Receipt
            </button>
            <a href="{{ route('books') }}" class="btn btn-primary px-4 py-2">
                <i class="fa-solid fa-book-open me-2"></i> Continue Exploring Books
            </a>
            <a href="{{ route('home') }}" class="btn btn-link text-decoration-none text-muted py-2">
                Back to Home
            </a>
        </div>
    </div>
</section>

@endsection
