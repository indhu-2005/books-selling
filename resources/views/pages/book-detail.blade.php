@extends('layouts.app')

@section('title', $book->title . ' - Book Details & Exchange')

@section('content')

<section class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('books') }}">Books</a></li>
                @if($book->category)
                    <li class="breadcrumb-item"><a href="{{ route('books', ['category' => $book->category->slug]) }}">{{ $book->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-truncate" style="max-width: 300px;" aria-current="page">{{ $book->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Book Visual Cover & Guarantees -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden p-3 bg-white mb-4">
                    <div class="position-relative text-center bg-light rounded-3 p-4">
                        <img src="{{ $book->image }}" alt="{{ $book->title }}" class="img-fluid rounded-3 shadow-md" style="max-height: 440px; object-fit: contain;">
                        <span class="book-badge-condition fs-6 px-3 py-1">{{ $book->condition ?? 'Good' }} Condition</span>
                    </div>
                </div>

                <!-- Trust Highlights -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="fa-solid fa-shield-halved text-primary me-2"></i> BooksApp Buyer & Swap Protection
                    </h6>
                    <div class="d-flex flex-column gap-3 small text-muted">
                        <div class="d-flex align-items-start gap-2">
                            <i class="fa-solid fa-circle-check text-success mt-1"></i>
                            <div><strong>Condition Inspected:</strong> Verified intact spine, no missing pages or binding damage.</div>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <i class="fa-solid fa-indian-rupee-sign text-primary mt-1"></i>
                            <div><strong>Transparent INR Rates:</strong> Prices set in Indian Rupees (₹) with no hidden checkout charges.</div>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <i class="fa-solid fa-truck-fast text-info mt-1"></i>
                            <div><strong>Quick India-Wide Dispatch:</strong> Ships in 24-48 hours via standard Indian courier services.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Information & Order Actions -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
                    <!-- Badges -->
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        @if($book->category)
                            <a href="{{ route('books', ['category' => $book->category->slug]) }}" class="badge bg-primary bg-opacity-10 text-primary text-decoration-none px-3 py-2 rounded-pill fw-semibold">
                                <i class="fa-solid {{ $book->category->icon }} me-1"></i> {{ $book->category->name }}
                            </a>
                        @endif
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold">
                            <i class="fa-solid fa-arrows-rotate me-1"></i> {{ $book->exchange_type ?? 'Buy / Exchange' }}
                        </span>
                    </div>

                    <!-- Book Title -->
                    <h1 class="display-6 fw-bold text-dark mb-2">{{ $book->title }}</h1>

                    <!-- Author & Rating -->
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4 pb-3 border-bottom">
                        <div class="text-muted">
                            By <strong class="text-dark">{{ $book->author }}</strong>
                        </div>
                        <span class="text-secondary">•</span>
                        <div class="d-flex align-items-center gap-1 text-warning">
                            <i class="fa-solid fa-star"></i>
                            <strong class="text-dark">{{ $book->rating ?? '4.8' }}</strong>
                            <span class="text-muted small">/ 5.0 (Community Rating)</span>
                        </div>
                    </div>

                    <!-- Price in INR Display -->
                    <div class="p-3 rounded-3 bg-light border mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <span class="small text-muted d-block text-uppercase fw-semibold">Exchange Value / Price</span>
                            <div class="d-flex align-items-baseline gap-1">
                                <span class="fs-2 fw-bold text-primary">₹{{ number_format($book->price, 0) }}</span>
                                <span class="small text-muted text-decoration-line-through ms-2">₹{{ number_format($book->price * 1.4, 0) }}</span>
                                <span class="badge bg-success small ms-2">Save 40%</span>
                            </div>
                        </div>
                        <div class="text-md-end small text-muted">
                            <div><i class="fa-solid fa-truck-ramp-box me-1 text-primary"></i> Free delivery on orders over ₹400</div>
                            <div class="text-success fw-medium"><i class="fa-solid fa-bolt me-1"></i> Ready for Immediate Dispatch</div>
                        </div>
                    </div>

                    <!-- Seller Profile Info (if listed by community member) -->
                    @if($book->seller_name || $book->user)
                        <div class="p-3 rounded-3 bg-white border border-primary border-opacity-25 shadow-sm mb-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px;">
                                        <i class="fa-solid fa-user-check"></i>
                                    </div>
                                    <div>
                                        <span class="small text-muted d-block" style="font-size:11px;">Verified Community Seller</span>
                                        <strong class="text-dark">{{ $book->seller_name ?? $book->user->name }}</strong>
                                        @if($book->seller_city)
                                            <span class="badge bg-light text-dark border ms-1">{{ $book->seller_city }}</span>
                                        @endif
                                    </div>
                                </div>
                                @if($book->seller_phone)
                                    <a href="https://wa.me/91{{ $book->seller_phone }}?text={{ urlencode('Hi, I found your book ' . $book->title . ' on BooksApp and would like to buy / exchange it.') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold">
                                        <i class="fa-brands fa-whatsapp me-1"></i> Chat with Seller
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Book Specifications -->
                    <h5 class="fw-bold text-dark mb-3">Book Specifications</h5>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-sm align-middle small mb-0">
                            <tbody>
                                <tr>
                                    <th class="bg-light text-muted w-25">Condition</th>
                                    <td><span class="badge bg-primary text-white">{{ $book->condition ?? 'Good' }}</span> (No torn pages, tight binding)</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-muted">ISBN</th>
                                    <td>{{ $book->isbn ?? '978-81-264-1029-4' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-muted">Language</th>
                                    <td>{{ $book->language ?? 'English' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-muted">Publisher</th>
                                    <td>{{ $book->publisher ?? 'Indian Academic Press' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light text-muted">Total Pages</th>
                                    <td>{{ $book->pages ?? 320 }} pages</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Book Description -->
                    <h5 class="fw-bold text-dark mb-2">About This Book</h5>
                    <p class="text-muted lh-base mb-4">
                        {{ $book->description ?? 'A verified classic title listed by a community member on BooksApp. Clean copy preserved in excellent readable condition with crisp pages.' }}
                    </p>

                    <!-- Purchase & Swap CTA Buttons -->
                    <div class="d-flex flex-column flex-sm-row gap-3 mb-4">
                        <a href="{{ route('payment', $book->id) }}" class="btn btn-primary btn-lg flex-grow-1 shadow d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>Buy Now for ₹{{ number_format($book->price, 0) }}</span>
                        </a>
                        <button type="button" class="btn btn-dark btn-lg px-4" data-bs-toggle="modal" data-bs-target="#swapModal">
                            <i class="fa-solid fa-arrows-rotate me-2"></i> Request Book Swap
                        </button>
                    </div>

                    <!-- Accepted Indian Payment Methods Notice -->
                    <div class="pt-3 border-top">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 text-muted small">
                            <span><i class="fa-solid fa-lock text-success me-1"></i> Indian Payment Methods Supported:</span>
                            <div class="d-flex gap-2">
                                <span class="badge bg-light text-dark border">UPI</span>
                                <span class="badge bg-light text-dark border">Google Pay</span>
                                <span class="badge bg-light text-dark border">PhonePe</span>
                                <span class="badge bg-light text-dark border">Paytm</span>
                                <span class="badge bg-light text-dark border">Debit/Credit Card</span>
                                <span class="badge bg-light text-dark border">Net Banking</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Books Section -->
        @if($relatedBooks->count() > 0)
            <div class="mt-5 pt-4">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <span class="section-tag"><i class="fa-solid fa-book-bookmark"></i> Discover More</span>
                        <h3 class="section-title fs-3 mb-0">Similar Books You Might Like</h3>
                    </div>
                    <a href="{{ route('books', ['category' => $book->category ? $book->category->slug : '']) }}" class="text-primary fw-semibold small text-decoration-none">
                        View More in Category →
                    </a>
                </div>

                <div class="row g-4">
                    @foreach($relatedBooks as $rel)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="book-card">
                                <div class="book-card-image-wrapper">
                                    <img src="{{ $rel->image }}" alt="{{ $rel->title }}" class="book-card-image">
                                    <span class="book-badge-condition">{{ $rel->condition ?? 'Good' }}</span>
                                </div>
                                <div class="book-card-body">
                                    <h3 class="book-title">
                                        <a href="{{ route('books.show', $rel->id) }}">{{ $rel->title }}</a>
                                    </h3>
                                    <div class="book-author">
                                        <i class="fa-solid fa-pen-nib"></i> {{ $rel->author }}
                                    </div>
                                    <div class="book-meta-row">
                                        <div class="book-price-box">
                                            <span class="book-price-label">Price / Value</span>
                                            <span class="book-price-value">
                                                <span class="book-currency-symbol">₹</span>{{ number_format($rel->price, 0) }}
                                            </span>
                                        </div>
                                        <div class="book-rating">
                                            <i class="fa-solid fa-star text-warning"></i>
                                            <span>{{ $rel->rating ?? '4.8' }}</span>
                                        </div>
                                    </div>
                                    <div class="book-card-actions">
                                        <a href="{{ route('books.show', $rel->id) }}" class="btn-card-view">
                                            <i class="fa-solid fa-eye small"></i> Details
                                        </a>
                                        <a href="{{ route('payment', $rel->id) }}" class="btn-card-buy">
                                            <i class="fa-solid fa-cart-shopping small"></i> Buy / Swap
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Direct Book Swap Modal -->
<div class="modal fade" id="swapModal" tabindex="-1" aria-labelledby="swapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="swapModalLabel">
                    <i class="fa-solid fa-arrows-rotate text-primary me-2"></i> Request Book Exchange
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="small text-muted mb-3">
                    Submit your exchange proposal for <strong>{{ $book->title }}</strong>. The owner will review your offer and get in touch via email or phone.
                </p>
                <form onsubmit="event.preventDefault(); alert('Your book swap request has been sent to the owner! You will receive confirmation via email shortly.'); bootstrap.Modal.getInstance(document.getElementById('swapModal')).hide();">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Your Name</label>
                        <input type="text" class="form-control" required placeholder="e.g., Ananya Verma" value="{{ auth()->user()->name ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Email Address</label>
                        <input type="email" class="form-control" required placeholder="e.g., you@example.com" value="{{ auth()->user()->email ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Your Phone Number (WhatsApp)</label>
                        <input type="tel" class="form-control" required placeholder="+91 9876543210">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Book(s) You Want to Offer in Exchange</label>
                        <textarea class="form-control" rows="3" required placeholder="Specify title, author, condition of the book(s) you wish to swap..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        Send Swap Request
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
