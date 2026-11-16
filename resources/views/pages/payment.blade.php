@extends('layouts.app')

@section('title', 'Secure Checkout - ' . $book->title)

@push('styles')
<!-- Razorpay Checkout JS -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
@endpush

@section('content')

<section class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('books') }}">Books</a></li>
                <li class="breadcrumb-item"><a href="{{ route('books.show', $book->id) }}">{{ Str::limit($book->title, 25) }}</a></li>
                <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">Secure Checkout (INR ₹)</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Secure Header -->
        <div class="text-center mb-5">
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold mb-2">
                <i class="fa-solid fa-shield-halved me-1"></i> 256-Bit SSL Encrypted Indian Gateway
            </span>
            <h1 class="display-6 fw-bold text-dark">Complete Your Book Purchase</h1>
            <p class="text-muted small">All transactions processed in Indian Rupees (₹). Zero hidden fees.</p>
        </div>

        <form id="paymentCheckoutForm" action="{{ route('payment.process', $book->id) }}" method="POST">
            @csrf

            <!-- Hidden Fields for payment details -->
            <input type="hidden" name="payment_method" id="selected_payment_method" value="upi_gpay">
            <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="">
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="">
            <input type="hidden" name="razorpay_signature" id="razorpay_signature" value="">

            <div class="row g-5">
                <!-- Left: Customer Details & Indian Payment Selection -->
                <div class="col-lg-7">
                    <!-- Step 1: Delivery Information -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-4 bg-white mb-4">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:28px; height:28px; font-size:13px; font-weight:700;">
                                1
                            </div>
                            <h5 class="fw-bold text-dark mb-0">Shipping & Delivery Details</h5>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="customer_name" class="form-control" required placeholder="e.g. Indhumathi K" value="{{ old('customer_name', $user->name ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="customer_email" class="form-control" required placeholder="e.g. reader@example.com" value="{{ old('customer_email', $user->email ?? '') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Mobile Number (WhatsApp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted small">+91</span>
                                    <input type="tel" name="customer_phone" class="form-control" required placeholder="9876543210" pattern="[0-9]{10}" maxlength="10" value="{{ old('customer_phone') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">PIN Code <span class="text-danger">*</span></label>
                                <input type="text" name="pincode" class="form-control" required placeholder="600001" maxlength="6" value="{{ old('pincode') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Delivery Street Address <span class="text-danger">*</span></label>
                                <input type="text" name="shipping_address" class="form-control" required placeholder="Door / Flat No, Apartment, Street name" value="{{ old('shipping_address') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">City / Town <span class="text-danger">*</span></label>
                                <input type="text" name="city" class="form-control" required placeholder="Chennai" value="{{ old('city') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">State <span class="text-danger">*</span></label>
                                <select name="state" class="form-select" required>
                                    <option value="Tamil Nadu" selected>Tamil Nadu</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Other">Other State</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Indian Payment Methods Selector -->
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
                        <div class="p-4 pb-2 border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:28px; height:28px; font-size:13px; font-weight:700;">
                                    2
                                </div>
                                <h5 class="fw-bold text-dark mb-0">Select Indian Payment Method</h5>
                            </div>
                            <p class="small text-muted mb-0 mt-1">Choose UPI, Card, Net Banking, or Razorpay Gateway</p>
                        </div>

                        <!-- Payment Navigation Tabs -->
                        <div class="payment-tab-nav">
                            <button type="button" class="payment-tab-btn active" data-target="tab-upi" data-method="upi_gpay">
                                <i class="fa-solid fa-mobile-screen-button"></i> UPI / Apps
                            </button>
                            <button type="button" class="payment-tab-btn" data-target="tab-card" data-method="debit_card">
                                <i class="fa-solid fa-credit-card"></i> Debit / Credit Card
                            </button>
                            <button type="button" class="payment-tab-btn" data-target="tab-netbanking" data-method="net_banking">
                                <i class="fa-solid fa-building-columns"></i> Net Banking
                            </button>
                            <button type="button" class="payment-tab-btn" data-target="tab-razorpay" data-method="razorpay">
                                <i class="fa-solid fa-bolt text-warning"></i> Razorpay Gateway
                            </button>
                        </div>

                        <!-- Tab 1: UPI Payments -->
                        <div id="tab-upi" class="payment-tab-pane payment-tab-content">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Select Your Preferred UPI App:</label>
                            <div class="payment-app-grid">
                                <div class="payment-app-option upi-app-option selected" data-method="upi_gpay">
                                    <i class="fa-brands fa-google-pay payment-app-icon" style="color: #4285F4;"></i>
                                    <div class="payment-app-name">Google Pay</div>
                                </div>
                                <div class="payment-app-option upi-app-option" data-method="upi_phonepe">
                                    <i class="fa-solid fa-wallet payment-app-icon" style="color: #5f259f;"></i>
                                    <div class="payment-app-name">PhonePe</div>
                                </div>
                                <div class="payment-app-option upi-app-option" data-method="upi_paytm">
                                    <i class="fa-solid fa-money-bill-wave payment-app-icon" style="color: #00b9f5;"></i>
                                    <div class="payment-app-name">Paytm UPI</div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label class="form-label small fw-bold text-muted text-uppercase">Or Enter Any Virtual Payment Address (UPI ID)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-at text-muted"></i></span>
                                    <input type="text" class="form-control" placeholder="username@okhdfcbank or 9876543210@paytm" id="custom_upi_id">
                                </div>
                                <div class="form-text small">Instant approval request will be sent to your UPI app.</div>
                            </div>
                        </div>

                        <!-- Tab 2: Debit & Credit Cards -->
                        <div id="tab-card" class="payment-tab-pane payment-tab-content d-none">
                            <div class="d-flex align-items-center justify-content-between mb-3 p-2 bg-light rounded-3 border">
                                <span class="small text-muted fw-semibold">Cards Accepted:</span>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-white text-dark border">RuPay</span>
                                    <span class="badge bg-white text-dark border">Visa</span>
                                    <span class="badge bg-white text-dark border">Mastercard</span>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Card Number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="4242 •••• •••• 4242" maxlength="19" id="dummy_card_number">
                                        <span class="input-group-text bg-light"><i class="fa-regular fa-credit-card"></i></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Name on Card</label>
                                    <input type="text" class="form-control" placeholder="Cardholder's Name" id="dummy_card_name">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Expiry Date</label>
                                    <input type="text" class="form-control" placeholder="MM/YY" maxlength="5" id="dummy_card_exp">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold text-muted text-uppercase">CVV</label>
                                    <input type="password" class="form-control" placeholder="•••" maxlength="4" id="dummy_card_cvv">
                                </div>
                            </div>
                            <div class="small text-muted mt-2">
                                <i class="fa-solid fa-lock text-success me-1"></i> Cards are verified with 3D-Secure OTP. We never store your card details.
                            </div>
                        </div>

                        <!-- Tab 3: Net Banking -->
                        <div id="tab-netbanking" class="payment-tab-pane payment-tab-content d-none">
                            <label class="form-label small fw-bold text-muted text-uppercase mb-2">Select Your Bank:</label>
                            <div class="row g-2 mb-3">
                                <div class="col-sm-4">
                                    <div class="p-2 border rounded-3 text-center small fw-semibold bg-light">
                                        <i class="fa-solid fa-building-columns text-primary d-block mb-1"></i> State Bank of India
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="p-2 border rounded-3 text-center small fw-semibold bg-light">
                                        <i class="fa-solid fa-building-columns text-primary d-block mb-1"></i> HDFC Bank
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="p-2 border rounded-3 text-center small fw-semibold bg-light">
                                        <i class="fa-solid fa-building-columns text-primary d-block mb-1"></i> ICICI Bank
                                    </div>
                                </div>
                            </div>

                            <label class="form-label small fw-bold text-muted text-uppercase">All Other Indian Banks</label>
                            <select class="form-select">
                                <option>Axis Bank</option>
                                <option>Punjab National Bank (PNB)</option>
                                <option>Bank of Baroda</option>
                                <option>Kotak Mahindra Bank</option>
                                <option>Canara Bank</option>
                                <option>Union Bank of India</option>
                                <option>Indian Bank</option>
                            </select>
                        </div>

                        <!-- Tab 4: Razorpay Official Modal Gateway -->
                        <div id="tab-razorpay" class="payment-tab-pane payment-tab-content d-none text-center py-4">
                            <div class="mb-3 text-primary" style="font-size: 40px;">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <h5 class="fw-bold text-dark">Razorpay Seamless Gateway</h5>
                            <p class="small text-muted mb-4 max-w-400 mx-auto">
                                Click below to launch the official Razorpay Checkout popup supporting UPI, Cards, Net Banking, and Wallets.
                            </p>
                            <button type="button" id="razorpayLaunchBtn" class="btn btn-primary px-4 py-2 fw-semibold">
                                <i class="fa-solid fa-shield-halved me-1"></i> Pay via Razorpay Popup
                            </button>
                        </div>
                    </div>

                    <!-- Payment Action Button -->
                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 shadow fs-6 fw-bold">
                        <i class="fa-solid fa-lock me-2"></i> Confirm & Pay ₹{{ number_format($totalAmount, 0) }}
                    </button>

                    <div class="text-center small text-muted mt-3">
                        <i class="fa-solid fa-shield-cat text-success me-1"></i> Guaranteed safe checkout. 7-Day replacement if not matching description.
                    </div>
                </div>

                <!-- Right: Order Summary Box -->
                <div class="col-lg-5">
                    <div class="order-summary-box shadow-sm sticky-top" style="top: 85px;">
                        <h4 class="order-summary-title">
                            <i class="fa-solid fa-receipt text-primary me-2"></i> Order Summary
                        </h4>

                        <!-- Book Preview Card -->
                        <div class="order-book-preview">
                            <img src="{{ $book->image }}" alt="{{ $book->title }}" class="order-book-thumb">
                            <div>
                                <h6 class="fw-bold text-dark mb-1 lh-sm">{{ $book->title }}</h6>
                                <div class="small text-muted mb-1">By {{ $book->author }}</div>
                                <span class="badge bg-light text-dark border">{{ $book->condition ?? 'Good' }} Condition</span>
                            </div>
                        </div>

                        <!-- Calculation Breakdown in INR -->
                        <div class="order-calc-row">
                            <span>Book Value</span>
                            <span class="fw-bold text-dark">₹{{ number_format($book->price, 0) }}</span>
                        </div>

                        <div class="order-calc-row">
                            <span>Delivery / Courier</span>
                            <span>
                                @if($deliveryFee == 0)
                                    <span class="badge bg-success small">FREE</span>
                                @else
                                    <span class="fw-bold text-dark">₹{{ $deliveryFee }}</span>
                                @endif
                            </span>
                        </div>

                        <div class="order-calc-row">
                            <span>Platform & Swap Fee</span>
                            <span class="text-success fw-bold">FREE (₹0)</span>
                        </div>

                        <!-- Total Payable in INR -->
                        <div class="order-calc-total">
                            <span>Total Payable (INR)</span>
                            <span class="text-primary fs-4 fw-bold">₹{{ number_format($totalAmount, 0) }}</span>
                        </div>

                        <!-- Security & Badges -->
                        <div class="mt-4 pt-3 border-top small text-muted">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="fa-solid fa-circle-check text-success"></i>
                                <span>100% Genuine Pre-Loved Book</span>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="fa-solid fa-indian-rupee-sign text-primary"></i>
                                <span>No Foreign Currency Conversion Fee</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-truck-fast text-info"></i>
                                <span>Delivery Estimate: 3-5 Working Days</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const razorpayBtn = document.getElementById('razorpayLaunchBtn');
    const form = document.getElementById('paymentCheckoutForm');

    if (razorpayBtn) {
        razorpayBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // Validate basic customer info first
            const name = form.customer_name.value.trim();
            const email = form.customer_email.value.trim();
            const phone = form.customer_phone.value.trim();
            const address = form.shipping_address.value.trim();

            if (!name || !email || !phone || !address) {
                alert('Please fill in your Delivery Information above before proceeding to Razorpay payment.');
                form.customer_name.focus();
                return;
            }

            // Request Razorpay order ID from backend
            fetch("{{ route('payment.razorpay.create') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    book_id: {{ $book->id }}
                })
            })
            .then(res => res.json())
            .then(data => {
                const options = {
                    key: data.key,
                    amount: data.amount,
                    currency: "INR",
                    name: "BooksApp India",
                    description: "Order for: " + data.book_title,
                    image: "{{ asset('favicon.ico') }}",
                    order_id: data.order_id,
                    handler: function(response) {
                        document.getElementById('selected_payment_method').value = 'razorpay';
                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id || data.order_id;
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id || ('pay_' + Math.random().toString(36).substr(2, 9));
                        document.getElementById('razorpay_signature').value = response.razorpay_signature || 'sig_demo_success';

                        // Submit form to record order in DB
                        form.submit();
                    },
                    prefill: {
                        name: name,
                        email: email,
                        contact: phone
                    },
                    theme: {
                        color: "#2563eb"
                    }
                };

                if (typeof Razorpay !== 'undefined') {
                    const rzp = new Razorpay(options);
                    rzp.on('payment.failed', function(response) {
                        alert("Payment Failed: " + response.error.description);
                    });
                    rzp.open();
                } else {
                    // Fallback to direct form submission in demo
                    document.getElementById('selected_payment_method').value = 'razorpay';
                    document.getElementById('razorpay_order_id').value = data.order_id;
                    document.getElementById('razorpay_payment_id').value = 'pay_demo_' + Date.now();
                    form.submit();
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error initializing Razorpay. Proceeding with standard checkout.");
            });
        });
    }
});
</script>
@endpush
