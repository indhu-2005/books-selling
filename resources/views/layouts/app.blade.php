<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BooksApp - @yield('title', 'Community Book Exchange Platform')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom Project Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

    @stack('styles')
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="site-navbar navbar navbar-expand-lg">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="brand-icon-box">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <span>Books<span class="brand-text-accent">App</span></span>
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars text-white fs-4"></i>
            </button>

            <!-- Navbar Links & Search -->
            <div class="collapse navbar-collapse" id="mainNavbar">
                <!-- Navigation Items -->
                <ul class="navbar-nav mx-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fa-solid fa-house-chimney me-1 small"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('books*') ? 'active' : '' }}" href="{{ route('books') }}">
                            <i class="fa-solid fa-book me-1 small"></i> Books
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('authors*') ? 'active' : '' }}" href="{{ route('authors') }}">
                            <i class="fa-solid fa-feather-pointed me-1 small"></i> Authors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('events*') ? 'active' : '' }}" href="{{ route('events') }}">
                            <i class="fa-solid fa-calendar-days me-1 small"></i> Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            <i class="fa-solid fa-circle-info me-1 small"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog*') ? 'active' : '' }}" href="{{ route('blog') }}">
                            <i class="fa-solid fa-newspaper me-1 small"></i> Blog
                        </a>
                    </li>
                </ul>

                <!-- Live Dynamic Search Bar -->
                <div class="search-container nav-search-form me-lg-3 my-2 my-lg-0">
                    <form action="{{ route('books') }}" method="GET" class="position-relative">
                        <input
                            type="text"
                            name="search"
                            class="nav-search-input live-search-input"
                            placeholder="Search books, authors, categories..."
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >
                        <button type="submit" class="nav-search-btn" title="Search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                    <!-- Search Dropdown is attached dynamically via main.js -->
                </div>

                <!-- Auth Buttons / User Profile & List a Book -->
                <div class="d-flex align-items-center">
                    <a href="{{ route('books.create') }}" class="btn btn-sm btn-outline-info rounded-pill px-3 me-2 fw-semibold text-white">
                        <i class="fa-solid fa-plus-circle me-1 text-info"></i> List a Book
                    </a>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-light dropdown-toggle d-flex align-items-center gap-2 rounded-pill px-3 py-1" type="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-circle-user text-info"></i>
                                <span>{{ auth()->user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <span class="dropdown-item-text text-muted small">Signed in as <strong>{{ auth()->user()->email }}</strong></span>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                @if(auth()->user()->is_admin)
                                    <li>
                                        <a class="dropdown-item small text-primary fw-bold" href="{{ route('admin.dashboard') }}">
                                            <i class="fa-solid fa-gauge-high me-2"></i> Admin Panel
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a class="dropdown-item small" href="{{ route('books.my') }}">
                                        <i class="fa-solid fa-book-medical me-2 text-primary"></i> My Listed Books
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item small" href="{{ route('books') }}">
                                        <i class="fa-solid fa-book-bookmark me-2 text-primary"></i> Browse Exchange
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item small text-danger">
                                            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-nav-login">Login</a>
                        <a href="{{ route('register') }}" class="btn-nav-signup ms-1">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Global Flash Alerts -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                <div class="fw-medium">{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                <i class="fa-solid fa-circle-exclamation fs-5 me-2 text-danger"></i>
                <div class="fw-medium">{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Main Content Yield -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Site Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <!-- Col 1: About BooksApp -->
                <div class="col-lg-4 col-md-6">
                    <a class="footer-brand" href="{{ route('home') }}">
                        <div class="brand-icon-box" style="width:32px; height:32px; font-size:15px;">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <span>Books<span class="brand-text-accent">App</span></span>
                    </a>
                    <p class="footer-desc">
                        India's community-driven Book Exchange platform. Connecting students, avid readers, and book lovers to share, swap, and purchase pre-loved books at fair Indian Rupee (₹) prices with seamless UPI and card payments.
                    </p>
                    <div class="d-flex gap-2">
                        <span class="badge bg-primary bg-opacity-25 text-info border border-info border-opacity-25 px-3 py-2 rounded-pill">
                            <i class="fa-solid fa-indian-rupee-sign me-1"></i> 100% Indian INR Payments
                        </span>
                        <span class="badge bg-primary bg-opacity-25 text-info border border-info border-opacity-25 px-3 py-2 rounded-pill">
                            <i class="fa-solid fa-leaf me-1"></i> Eco-Friendly Swaps
                        </span>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="fa-solid fa-chevron-right small"></i> Home</a></li>
                        <li><a href="{{ route('books') }}"><i class="fa-solid fa-chevron-right small"></i> All Books</a></li>
                        <li><a href="{{ route('authors') }}"><i class="fa-solid fa-chevron-right small"></i> Authors</a></li>
                        <li><a href="{{ route('events') }}"><i class="fa-solid fa-chevron-right small"></i> Community Events</a></li>
                        <li><a href="{{ route('about') }}"><i class="fa-solid fa-chevron-right small"></i> About Platform</a></li>
                        <li><a href="{{ route('blog') }}"><i class="fa-solid fa-chevron-right small"></i> Reading Blog</a></li>
                    </ul>
                </div>

                <!-- Col 3: Categories -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Book Categories</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('books', ['category' => 'school-books']) }}"><i class="fa-solid fa-graduation-cap small"></i> School Books (CBSE/State)</a></li>
                        <li><a href="{{ route('books', ['category' => 'college-books']) }}"><i class="fa-solid fa-building-columns small"></i> College Books (Engg/Med)</a></li>
                        <li><a href="{{ route('books', ['category' => 'educational-books']) }}"><i class="fa-solid fa-brain small"></i> Educational & Competitive</a></li>
                        <li><a href="{{ route('books', ['category' => 'novels']) }}"><i class="fa-solid fa-book-bookmark small"></i> Novels & Literature</a></li>
                        <li><a href="{{ route('books', ['category' => 'story-books']) }}"><i class="fa-solid fa-wand-magic-sparkles small"></i> Story Books for Kids</a></li>
                        <li><a href="{{ route('books', ['category' => 'fiction']) }}"><i class="fa-solid fa-dragon small"></i> Fiction & Fantasy</a></li>
                        <li><a href="{{ route('books', ['category' => 'non-fiction']) }}"><i class="fa-solid fa-lightbulb small"></i> Non-Fiction & Self-Help</a></li>
                    </ul>
                </div>

                <!-- Col 4: Payments & Trust -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Secure Indian Payments</h5>
                    <p class="small text-muted mb-3">
                        We support all leading Indian payment gateways with zero checkout friction:
                    </p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-light text-dark border px-2 py-1"><i class="fa-solid fa-mobile-screen-button text-primary me-1"></i> UPI</span>
                        <span class="badge bg-light text-dark border px-2 py-1"><i class="fa-brands fa-google-pay text-primary me-1"></i> Google Pay</span>
                        <span class="badge bg-light text-dark border px-2 py-1"><i class="fa-solid fa-wallet text-primary me-1"></i> PhonePe</span>
                        <span class="badge bg-light text-dark border px-2 py-1"><i class="fa-solid fa-credit-card text-primary me-1"></i> Paytm</span>
                        <span class="badge bg-light text-dark border px-2 py-1"><i class="fa-solid fa-credit-card text-primary me-1"></i> Debit / Credit Card</span>
                        <span class="badge bg-light text-dark border px-2 py-1"><i class="fa-solid fa-building-columns text-primary me-1"></i> Net Banking</span>
                    </div>
                    <div class="small text-muted">
                        <i class="fa-solid fa-shield-halved text-success me-1"></i> 256-Bit SSL Encrypted Transactions.
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div>
                    © {{ date('Y') }} BooksApp. All rights reserved. Built for passionate readers across India.
                </div>
                <div class="d-flex gap-3">
                    <a href="{{ route('about') }}" class="text-secondary text-decoration-none small hover-sky">Privacy Policy</a>
                    <span class="text-secondary">•</span>
                    <a href="{{ route('about') }}" class="text-secondary text-decoration-none small hover-sky">Terms of Exchange</a>
                    <span class="text-secondary">•</span>
                    <a href="{{ route('about') }}" class="text-secondary text-decoration-none small hover-sky">Contact Us</a>
                    <span class="text-secondary">•</span>
                    <a href="{{ route('admin.login') }}" class="text-secondary text-decoration-none small hover-sky">
                        <i class="fa-solid fa-lock small me-1"></i> Admin Login
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Project JavaScript -->
    <script src="{{ asset('js/main.js') }}?v={{ time() }}"></script>

    @stack('scripts')
</body>
</html>
