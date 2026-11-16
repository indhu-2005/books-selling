@extends('layouts.app')

@section('title', 'All Books - Browse Catalog & Filter by Category')

@section('content')

<!-- Page Header Banner -->
<section class="page-header-banner">
    <div class="container text-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Books</li>
                @if($selectedCategory)
                    <li class="breadcrumb-item active text-white" aria-current="page">{{ $selectedCategory->name }}</li>
                @endif
            </ol>
        </nav>
        <h1 class="page-header-title">
            @if($selectedCategory)
                {{ $selectedCategory->name }}
            @elseif($search)
                Search Results for "{{ $search }}"
            @else
                Explore All Books
            @endif
        </h1>
        <p class="page-header-desc">
            @if($selectedCategory)
                {{ $selectedCategory->description }}
            @else
                Discover quality pre-loved and exchangeable books across curricula, classical literature, and bestsellers at transparent INR (₹) rates.
            @endif
        </p>
    </div>
</section>

<!-- Main Catalog Container -->
<section class="pb-5">
    <div class="container">
        <!-- Horizontal Category Pills Bar -->
        <div class="d-flex align-items-center gap-2 overflow-auto pb-3 mb-4 border-bottom">
            <a href="{{ route('books', request()->except('category', 'page')) }}" class="category-pill {{ !$categorySlug ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i> All Categories
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('books', array_merge(request()->except('page'), ['category' => $cat->slug])) }}" class="category-pill {{ $categorySlug === $cat->slug ? 'active' : '' }}">
                    <i class="fa-solid {{ $cat->icon }}"></i> {{ $cat->name }}
                    <span class="badge bg-secondary bg-opacity-25 text-dark ms-1">{{ $cat->books_count }}</span>
                </a>
            @endforeach
        </div>

        <div class="row g-4">
            <!-- Sidebar Filters -->
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 85px; z-index: 10;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fa-solid fa-sliders text-primary me-2"></i> Filters
                        </h5>
                        @if($search || $categorySlug || $condition || $sort !== 'latest' || $minPrice || $maxPrice || $authorSlug)
                            <a href="{{ route('books') }}" class="small text-danger text-decoration-none fw-semibold">
                                <i class="fa-solid fa-xmark"></i> Clear All
                            </a>
                        @endif
                    </div>

                    <form action="{{ route('books') }}" method="GET">
                        <!-- Keep category if set -->
                        @if($categorySlug)
                            <input type="hidden" name="category" value="{{ $categorySlug }}">
                        @endif

                        <!-- Search Input Filter -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Keyword Search</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Title, author, keyword..." value="{{ $search }}">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Condition Filter -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Book Condition</label>
                            <select name="condition" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="" {{ !$condition ? 'selected' : '' }}>All Conditions</option>
                                <option value="Brand New" {{ $condition === 'Brand New' ? 'selected' : '' }}>Brand New</option>
                                <option value="Like New" {{ $condition === 'Like New' ? 'selected' : '' }}>Like New</option>
                                <option value="Very Good" {{ $condition === 'Very Good' ? 'selected' : '' }}>Very Good</option>
                                <option value="Good" {{ $condition === 'Good' ? 'selected' : '' }}>Good</option>
                            </select>
                        </div>

                        <!-- Author Filter -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Author</label>
                            <select name="author" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="" {{ !$authorSlug ? 'selected' : '' }}>All Authors</option>
                                @foreach($authors as $author)
                                    <option value="{{ $author->slug }}" {{ $authorSlug === $author->slug ? 'selected' : '' }}>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sorting -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Sort By</label>
                            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Newest Listed</option>
                                <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="rating" {{ $sort === 'rating' ? 'selected' : '' }}>Highest Rated</option>
                                <option value="title_asc" {{ $sort === 'title_asc' ? 'selected' : '' }}>Title: A to Z</option>
                            </select>
                        </div>

                        <!-- Price Range in INR -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Price Range (₹)</label>
                            <div class="d-flex gap-2">
                                <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min ₹" value="{{ $minPrice }}">
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max ₹" value="{{ $maxPrice }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">
                            Apply Filters
                        </button>
                    </form>
                </div>
            </div>

            <!-- Books Grid & Results -->
            <div class="col-lg-9">
                <!-- Top Status Bar -->
                <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white rounded-3 shadow-sm border">
                    <div class="small text-muted">
                        Showing <strong>{{ $books->firstItem() ?? 0 }}-{{ $books->lastItem() ?? 0 }}</strong> of <strong>{{ $books->total() }}</strong> books available
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="small text-muted d-none d-sm-inline">Sort:</span>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('books', array_merge(request()->all(), ['sort' => 'latest'])) }}" class="btn {{ $sort === 'latest' ? 'btn-primary' : 'btn-outline-secondary' }}">Latest</a>
                            <a href="{{ route('books', array_merge(request()->all(), ['sort' => 'price_low'])) }}" class="btn {{ $sort === 'price_low' ? 'btn-primary' : 'btn-outline-secondary' }}">Price: Low</a>
                            <a href="{{ route('books', array_merge(request()->all(), ['sort' => 'price_high'])) }}" class="btn {{ $sort === 'price_high' ? 'btn-primary' : 'btn-outline-secondary' }}">Price: High</a>
                        </div>
                    </div>
                </div>

                <!-- Active Filter Tags -->
                @if($search || $categorySlug || $condition || $authorSlug)
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @if($search)
                            <span class="badge bg-light text-dark border p-2">
                                Query: "{{ $search }}"
                                <a href="{{ route('books', request()->except('search', 'page')) }}" class="ms-1 text-danger"><i class="fa-solid fa-xmark"></i></a>
                            </span>
                        @endif
                        @if($categorySlug)
                            <span class="badge bg-light text-dark border p-2">
                                Category: {{ $selectedCategory ? $selectedCategory->name : $categorySlug }}
                                <a href="{{ route('books', request()->except('category', 'page')) }}" class="ms-1 text-danger"><i class="fa-solid fa-xmark"></i></a>
                            </span>
                        @endif
                        @if($condition)
                            <span class="badge bg-light text-dark border p-2">
                                Condition: {{ $condition }}
                                <a href="{{ route('books', request()->except('condition', 'page')) }}" class="ms-1 text-danger"><i class="fa-solid fa-xmark"></i></a>
                            </span>
                        @endif
                        @if($authorSlug)
                            <span class="badge bg-light text-dark border p-2">
                                Author: {{ $authorSlug }}
                                <a href="{{ route('books', request()->except('author', 'page')) }}" class="ms-1 text-danger"><i class="fa-solid fa-xmark"></i></a>
                            </span>
                        @endif
                    </div>
                @endif

                <!-- Books Grid -->
                <div class="row g-4">
                    @forelse($books as $book)
                        <div class="col-xl-4 col-md-6">
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
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-3">
                                <div class="mb-3 text-secondary" style="font-size: 48px;">
                                    <i class="fa-solid fa-book-skull"></i>
                                </div>
                                <h4 class="fw-bold mb-2">No matching books found</h4>
                                <p class="text-muted mb-4 max-w-500 mx-auto">
                                    We couldn't find any books matching your current search or filter criteria. Try adjusting keywords or clearing filters.
                                </p>
                                <div>
                                    <a href="{{ route('books') }}" class="btn btn-primary px-4">
                                        <i class="fa-solid fa-rotate-left me-2"></i> Reset All Filters
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Links -->
                <div class="mt-4 d-flex justify-content-center">
                    {{ $books->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
