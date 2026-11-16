@extends('layouts.app')

@section('title', $author->name . ' - Author Profile & Books')

@section('content')

<!-- Author Profile Banner -->
<section class="page-header-banner">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('authors') }}">Authors</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $author->name }}</li>
            </ol>
        </nav>

        <div class="row align-items-center g-4 mt-2">
            <div class="col-md-auto text-center text-md-start">
                <img src="{{ $author->photo }}" alt="{{ $author->name }}" class="rounded-circle shadow-lg border border-3 border-white" style="width: 140px; height: 140px; object-fit: cover;">
            </div>
            <div class="col-md">
                <div class="badge bg-primary bg-opacity-25 text-info px-3 py-1 rounded-pill mb-2">
                    <i class="fa-solid fa-feather-pointed me-1"></i> {{ $author->genre }}
                </div>
                <h1 class="page-header-title mb-2">{{ $author->name }}</h1>
                <p class="page-header-desc mb-3" style="max-width: 800px;">
                    {{ $author->bio }}
                </p>
                <div class="d-flex flex-wrap gap-3 small text-light">
                    @if($author->nationality)
                        <span><i class="fa-solid fa-earth-asia text-info me-1"></i> Nationality: <strong>{{ $author->nationality }}</strong></span>
                    @endif
                    <span><i class="fa-solid fa-book text-info me-1"></i> Books Available: <strong>{{ $author->books->count() }}</strong></span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Author's Books Catalog -->
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <span class="section-tag"><i class="fa-solid fa-book-open"></i> Catalog</span>
                <h3 class="section-title fs-3 mb-0">Books by {{ $author->name }}</h3>
            </div>
            <a href="{{ route('books') }}" class="btn btn-outline-primary btn-sm">
                Explore All Authors' Books
            </a>
        </div>

        <div class="row g-4">
            @forelse($author->books as $book)
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
                    <p class="text-muted">No books currently listed for this author. Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
