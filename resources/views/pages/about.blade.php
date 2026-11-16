@extends('layouts.app')

@section('title', 'About BooksApp - India\'s Community Book Exchange Platform')

@section('content')

<!-- Page Header Banner -->
<section class="page-header-banner">
    <div class="container text-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">About</li>
            </ol>
        </nav>
        <h1 class="page-header-title">Connecting Readers, One Book at a Time</h1>
        <p class="page-header-desc">
            BooksApp is India's dedicated Book Exchange and pre-loved book marketplace, created to make quality reading and educational curricula accessible, affordable, and environmentally sustainable.
        </p>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-tag"><i class="fa-solid fa-bullseye"></i> Our Purpose</span>
                <h2 class="section-title">Democratizing Knowledge Across India</h2>
                <p class="text-muted lh-base mb-3">
                    Every year in India, millions of academic textbooks, engineering volumes, medical guides, and beloved novels sit unread on personal bookshelves after exams finish. Meanwhile, incoming students and enthusiastic readers struggle to afford steep new book prices.
                </p>
                <p class="text-muted lh-base mb-4">
                    BooksApp bridges this divide. We provide an intuitive, trustworthy platform where students and readers can exchange books title-for-title or purchase pre-loved editions at transparent Indian Rupee (<strong class="text-dark">₹</strong>) prices using familiar Indian payment methods like UPI, RuPay cards, and Net Banking.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 bg-light border">
                            <h6 class="fw-bold text-primary mb-1"><i class="fa-solid fa-leaf me-1"></i> Eco-Friendly Reading</h6>
                            <p class="small text-muted mb-0">Every book shared prevents trees from being felled and reduces paper waste.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-3 bg-light border">
                            <h6 class="fw-bold text-primary mb-1"><i class="fa-solid fa-wallet me-1"></i> Massive Student Savings</h6>
                            <p class="small text-muted mb-0">Save up to 70% on college and school curricula every academic semester.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=700&auto=format&fit=crop&q=80" alt="Bookshelf Library" class="img-fluid rounded-4 shadow-lg">
                    <div class="p-4 rounded-3 bg-white shadow-md border position-absolute bottom-0 start-0 m-3 d-none d-sm-block" style="max-width: 280px;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 20px;">
                                <i class="fa-solid fa-indian-rupee-sign"></i>
                            </div>
                            <div>
                                <div class="fs-5 fw-bold text-dark">₹{{ number_format($rupeesSaved, 0) }}+</div>
                                <div class="small text-muted">Estimated Community Savings</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Impact Metrics Counter -->
<section class="py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); color: white;">
    <div class="container text-center">
        <span class="badge bg-white bg-opacity-20 text-info px-3 py-1 rounded-pill mb-3">Our Footprint</span>
        <h2 class="display-6 fw-bold mb-5">Growing Community Impact</h2>

        <div class="row g-4 justify-content-center">
            <div class="col-6 col-md-3">
                <div class="p-3">
                    <div class="display-5 fw-bold text-info mb-1">{{ $booksCount * 12 }}+</div>
                    <div class="small text-light">Books Shared & Exchanged</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3">
                    <div class="display-5 fw-bold text-info mb-1">{{ $categoriesCount }}</div>
                    <div class="small text-light">Active Subject Categories</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3">
                    <div class="display-5 fw-bold text-info mb-1">{{ $treesSaved }}+</div>
                    <div class="small text-light">Equivalent Trees Preserved</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-3">
                    <div class="display-5 fw-bold text-info mb-1">100%</div>
                    <div class="small text-light">Verified Quality Guarantee</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works 4-Step Diagram -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="section-tag"><i class="fa-solid fa-list-check"></i> Step-by-Step</span>
            <h2 class="section-title">How the Book Exchange Works</h2>
            <p class="section-subtitle">A transparent, community-driven workflow tailored for readers and scholars.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="feature-box">
                    <div class="feature-box-icon">
                        <i class="fa-solid fa-book-medical"></i>
                    </div>
                    <h4 class="feature-box-title">Step 1: List or Search</h4>
                    <p class="feature-box-desc">
                        Browse verified titles in School, College, Novels, or competitive exam sections, or list your pre-loved book in 2 minutes.
                    </p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="feature-box">
                    <div class="feature-box-icon">
                        <i class="fa-solid fa-comments"></i>
                    </div>
                    <h4 class="feature-box-title">Step 2: Propose Swap</h4>
                    <p class="feature-box-desc">
                        Connect directly with the book owner to offer another book in exchange, or choose instant purchase at pre-loved INR prices.
                    </p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="feature-box">
                    <div class="feature-box-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h4 class="feature-box-title">Step 3: Secure Checkout</h4>
                    <p class="feature-box-desc">
                        Pay safely using your preferred Indian payment methods: UPI (GPay, PhonePe, Paytm), RuPay/Visa cards, or Net Banking.
                    </p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="feature-box">
                    <div class="feature-box-icon">
                        <i class="fa-solid fa-truck"></i>
                    </div>
                    <h4 class="feature-box-title">Step 4: Swift Delivery</h4>
                    <p class="feature-box-desc">
                        Receive your book tracked to your doorstep or meet safely at university swap stations and community reading meets.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Frequently Asked Questions (FAQ) -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container max-w-900">
        <div class="text-center mb-5">
            <span class="section-tag"><i class="fa-solid fa-circle-question"></i> Help & FAQs</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Everything you need to know about swapping and buying books on BooksApp.</p>
        </div>

        <div class="accordion shadow-sm rounded-4 overflow-hidden" id="faqAccordion">
            <div class="accordion-item border-0 border-bottom">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button fw-bold text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        <i class="fa-solid fa-arrows-rotate text-primary me-2"></i> How does the direct book swap work?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted small lh-base">
                        When you browse any book marked for exchange, you can click "Request Book Swap" and list the book(s) you would like to trade. Both parties agree on the swap, and books can either be exchanged in person at our community meets or shipped via courier.
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 border-bottom">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        <i class="fa-solid fa-indian-rupee-sign text-primary me-2"></i> Which Indian payment methods are supported?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted small lh-base">
                        We natively support all major Indian payment gateways and rails: UPI (Google Pay, PhonePe, Paytm, BHIM, any UPI ID), RuPay, Visa & Mastercard debit and credit cards, and Net Banking across all leading public and private Indian banks. All prices are calculated and displayed in Indian Rupees (₹).
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0 border-bottom">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                        <i class="fa-solid fa-check-double text-primary me-2"></i> How do you verify book condition?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted small lh-base">
                        Every book listed is graded according to clear criteria: <em>Brand New</em> (unopened), <em>Like New</em> (minimal signs of handling), <em>Very Good</em> (clean spine, no highlighting), and <em>Good</em> (complete text with mild cover wear). If a received book does not match its listed condition, our buyer protection covers a free return or exchange.
                    </div>
                </div>
            </div>

            <div class="accordion-item border-0">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed fw-bold text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                        <i class="fa-solid fa-lock text-primary me-2"></i> Is my payment information secure?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-muted small lh-base">
                        Absolutely. We strictly enforce PCI-DSS standards. We never store credit or debit card numbers, CVVs, or UPI PINs on our servers. All transaction processing is encrypted using 256-bit SSL protocols.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
