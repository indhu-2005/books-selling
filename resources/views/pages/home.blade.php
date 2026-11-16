@extends('layouts.app')

@section('title', 'Home - India\'s Community Book Exchange Platform')

@section('content')

<!-- Hero Section -->
<section class="hero-wrapper">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="fa-solid fa-leaf"></i> Sustainable Reading • 100% Indian Book Exchange
                </div>
                <h1 class="hero-title">
                    Exchange, Read & Share Books with Fellow Readers
                </h1>
                <p class="hero-subtitle">
                    Turn your finished books into new adventures. Swap textbooks, novels, and educational guides or purchase pre-loved books at affordable Indian Rupee (<span class="fw-bold text-white">₹</span>) rates with seamless UPI and card payments.
                </p>

                <!-- Modern Hero Search Bar -->
                <div class="hero-search-card search-container position-relative mb-4">
                    <form action="{{ route('books') }}" method="GET" class="hero-search-form">
                        <i class="fa-solid fa-magnifying-glass text-muted ms-3 fs-5"></i>
                        <input
                            type="text"
                            name="search"
                            class="hero-search-input live-search-input"
                            placeholder="Search by book title, author, or category (e.g., NCERT, Kalam, Fiction)..."
                            autocomplete="off"
                        >
                        <button type="submit" class="hero-search-btn">
                            <span>Search Books</span>
                            <i class="fa-solid fa-arrow-right small"></i>
                        </button>
                    </form>
                </div>

                <!-- Fast Category Shortcuts -->
                <div class="d-flex flex-wrap align-items-center gap-2 pt-2">
                    <span class="text-white small fw-medium me-1">Popular:</span>
                    <a href="{{ route('books', ['category' => 'college-books']) }}" class="badge bg-white bg-opacity-25 text-white text-decoration-none px-3 py-2 rounded-pill hover-scale">
                        <i class="fa-solid fa-building-columns me-1"></i> College Books
                    </a>
                    <a href="{{ route('books', ['category' => 'school-books']) }}" class="badge bg-white bg-opacity-25 text-white text-decoration-none px-3 py-2 rounded-pill hover-scale">
                        <i class="fa-solid fa-graduation-cap me-1"></i> School Books
                    </a>
                    <a href="{{ route('books', ['category' => 'novels']) }}" class="badge bg-white bg-opacity-25 text-white text-decoration-none px-3 py-2 rounded-pill hover-scale">
                        <i class="fa-solid fa-book-bookmark me-1"></i> Novels
                    </a>
                    <a href="{{ route('books', ['category' => 'educational-books']) }}" class="badge bg-white bg-opacity-25 text-white text-decoration-none px-3 py-2 rounded-pill hover-scale">
                        <i class="fa-solid fa-brain me-1"></i> Educational
                    </a>
                </div>
                <!-- Action Buttons in Hero -->
                <div class="mt-4 d-flex flex-wrap gap-3">
                    <a href="{{ route('books.create') }}" class="btn btn-light fw-bold text-primary rounded-pill px-4 py-2 shadow">
                        <i class="fa-solid fa-plus-circle me-1"></i> List Your Book (Sell / Swap)
                    </a>
                    <a href="{{ route('books') }}" class="btn btn-outline-light rounded-pill px-4 py-2">
                        <i class="fa-solid fa-book-open me-1"></i> Browse Catalog
                    </a>
                </div>
            </div>

            <!-- Hero Side Graphic & Community Counters -->
            <div class="col-lg-5">
                <div class="p-4 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg text-white">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" style="width:50px; height:50px; font-size:22px;">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Live Community Exchange</h5>
                            <span class="small text-info">Connecting Readers Nationwide</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6">
                            <div class="hero-stat-pill">
                                <div class="hero-stat-number">{{ $booksCount }}+</div>
                                <div class="hero-stat-label">Available Books</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat-pill">
                                <div class="hero-stat-number">{{ $categories->count() }}</div>
                                <div class="hero-stat-label">Curated Categories</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat-pill">
                                <div class="hero-stat-number">{{ $authorsCount }}+</div>
                                <div class="hero-stat-label">Notable Authors</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat-pill">
                                <div class="hero-stat-number">100%</div>
                                <div class="hero-stat-label">Secure INR UPI / Cards</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top border-white border-opacity-20 d-flex justify-content-between align-items-center">
                        <div class="small">
                            <i class="fa-solid fa-shield-halved text-info me-1"></i> Verified Book Conditions
                        </div>
                        <a href="{{ route('books') }}" class="btn btn-sm btn-light fw-bold text-primary px-3 rounded-pill">
                            Explore Catalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Book Categories Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4">
            <div>
                <span class="section-tag"><i class="fa-solid fa-layer-group"></i> Browse Categories</span>
                <h2 class="section-title">Explore Books by Category</h2>
                <p class="section-subtitle mb-0">From academic curricula to timeless literature and bedtime tales.</p>
            </div>
            <a href="{{ route('books') }}" class="btn btn-outline-primary mt-3 mt-md-0">
                View All Categories <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-3">
            @foreach($categories as $cat)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <a href="{{ route('books', ['category' => $cat->slug]) }}" class="category-card">
                        <div class="category-card-icon">
                            <i class="fa-solid {{ $cat->icon }}"></i>
                        </div>
                        <h4 class="category-card-title">{{ $cat->name }}</h4>
                        <span class="category-card-count">{{ $cat->books_count }} Books Listed</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured & Popular Books Section -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4">
            <div>
                <span class="section-tag"><i class="fa-solid fa-fire text-warning"></i> Handpicked Selection</span>
                <h2 class="section-title">Featured Books for Exchange & Purchase</h2>
                <p class="section-subtitle mb-0">All books verified for quality condition with transparent INR (<span class="fw-bold">₹</span>) pricing.</p>
            </div>
            <a href="{{ route('books') }}" class="btn btn-primary mt-3 mt-md-0">
                Browse Full Catalog <i class="fa-solid fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse($featuredBooks as $book)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="book-card">
                        <div class="book-card-image-wrapper">
                            <img src="{{ $book->image }}" alt="{{ $book->title }}" class="book-card-image">
                            <span class="book-badge-condition">{{ $book->condition ?? 'Good' }}</span>
                            @if($book->category)
                                <span class="book-badge-category">{{ $book->category->name }}</span>
                            @endif
                        </div>
                        <div class="book-card-body">
                            <h3 class="book-title">
                                <a href="{{ route('books.show', $book->id) }}">{{ $book->title }}</a>
                            </h3>
                            <div class="book-author">
                                <i class="fa-solid fa-pen-nib"></i> {{ $book->author }}
                            </div>

                            <div class="book-meta-row">
                                <div class="book-price-box">
                                    <span class="book-price-label">Price / Value</span>
                                    <span class="book-price-value">
                                        <span class="book-currency-symbol">₹</span>{{ number_format($book->price, 0) }}
                                    </span>
                                </div>
                                <div class="book-rating">
                                    <i class="fa-solid fa-star text-warning"></i>
                                    <span>{{ $book->rating ?? '4.8' }}</span>
                                </div>
                            </div>

                            <div class="book-card-actions">
                                <a href="{{ route('books.show', $book->id) }}" class="btn-card-view">
                                    <i class="fa-solid fa-eye small"></i> Details
                                </a>
                                <a href="{{ route('payment', $book->id) }}" class="btn-card-buy">
                                    <i class="fa-solid fa-cart-shopping small"></i> Buy / Swap
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No books available at this moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- How Book Exchange Works Section -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="text-center max-w-700 mx-auto mb-5">
            <span class="section-tag"><i class="fa-solid fa-rotate"></i> Seamless Process</span>
            <h2 class="section-title">How BooksApp Works</h2>
            <p class="section-subtitle">
                Simple, reliable, and transparent steps to swap or buy books in your neighborhood or college campus.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-box-icon">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="feature-box-title">1. Discover or List</h3>
                    <p class="feature-box-desc">
                        Search across School, College, Novels, and Exam books, or list your completed reads for exchange with simple details.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-box-icon">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h3 class="feature-box-title">2. Choose Swap or Buy</h3>
                    <p class="feature-box-desc">
                        Directly swap title-for-title with fellow readers, or purchase instantly at reasonable pre-loved INR (₹) rates.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-box-icon">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>
                    <h3 class="feature-box-title">3. Indian Payments</h3>
                    <p class="feature-box-desc">
                        Pay conveniently using UPI (Google Pay, PhonePe, Paytm), RuPay/Visa Cards, or Net Banking with 100% bank-grade encryption.
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="feature-box">
                    <div class="feature-box-icon">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="feature-box-title">4. Deliver & Enjoy</h3>
                    <p class="feature-box-desc">
                        Get books securely delivered to your doorstep or meet at local campus swap spots to read, learn, and save paper.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Community Events & Reading Blog Grid -->
<section class="py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row g-5">
            <!-- Left: Upcoming Events -->
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="section-tag"><i class="fa-solid fa-calendar-check"></i> Community</span>
                        <h3 class="section-title fs-3 mb-0">Upcoming Book Meets</h3>
                    </div>
                    <a href="{{ route('events') }}" class="text-primary fw-semibold small text-decoration-none">
                        View All Events →
                    </a>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($upcomingEvents as $event)
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden p-3 bg-white">
                            <div class="d-flex gap-3 align-items-start">
                                <div class="text-center rounded-3 p-2 bg-light border text-primary flex-shrink-0" style="min-width: 65px;">
                                    <span class="d-block fw-bold fs-4">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
                                    <span class="small text-uppercase fw-semibold">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="badge bg-primary bg-opacity-10 text-primary small mb-1">{{ $event->event_type }}</span>
                                    <h5 class="fs-6 fw-bold mb-1">{{ $event->title }}</h5>
                                    <div class="small text-muted mb-2">
                                        <i class="fa-solid fa-location-dot me-1 text-secondary"></i> {{ Str::limit($event->location, 45) }}
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-success bg-opacity-10 text-success small">{{ $event->entry_fee }}</span>
                                        <a href="{{ route('events') }}" class="btn btn-sm btn-outline-primary py-1 px-3">
                                            RSVP Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small">No upcoming events scheduled at the moment.</p>
                    @endforelse
                </div>
            </div>

            <!-- Right: Latest Blog Posts -->
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <span class="section-tag"><i class="fa-solid fa-feather-pointed"></i> Reading Insights</span>
                        <h3 class="section-title fs-3 mb-0">From Our Blog</h3>
                    </div>
                    <a href="{{ route('blog') }}" class="text-primary fw-semibold small text-decoration-none">
                        Read All Articles →
                    </a>
                </div>

                <div class="d-flex flex-column gap-3">
                    @forelse($recentPosts as $post)
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden p-3 bg-white">
                            <div class="d-flex gap-3 align-items-center">
                                <img src="{{ $post->image }}" alt="{{ $post->title }}" class="rounded-3 flex-shrink-0" style="width: 85px; height: 75px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="badge bg-info bg-opacity-10 text-dark small">{{ $post->category }}</span>
                                        <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> {{ $post->read_time }}</span>
                                    </div>
                                    <h5 class="fs-6 fw-bold mb-1">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="text-dark text-decoration-none hover-primary">
                                            {{ Str::limit($post->title, 55) }}
                                        </a>
                                    </h5>
                                    <div class="small text-muted">
                                        By {{ $post->author_name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small">No blog articles published yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section class="py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%); color: white;">
    <div class="container text-center py-4">
        <h2 class="display-6 fw-bold mb-3">Join Thousands of Indian Readers & Students</h2>
        <p class="lead text-light mb-4 max-w-650 mx-auto">
            Ready to find your next favorite novel or swap your previous semester college textbooks? Start exploring our catalog now.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('books') }}" class="btn btn-primary btn-lg px-4 shadow">
                <i class="fa-solid fa-book-open me-2"></i> Browse All Books
            </a>
            <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg px-4">
                <i class="fa-solid fa-circle-question me-2"></i> Learn More
            </a>
        </div>
    </div>
</section>

@endsection
