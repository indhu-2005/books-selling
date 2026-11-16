@extends('layouts.app')

@section('title', 'My Listed Books - BooksApp')

@section('content')

<section class="page-header-banner">
    <div class="container text-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('books') }}">Books</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">My Listed Books</li>
            </ol>
        </nav>
        <h1 class="page-header-title">My Book Listings</h1>
        <p class="page-header-desc">
            Manage your books available for exchange and sale. You can update listings, review inquiries, or remove completed swaps.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <span class="section-tag"><i class="fa-solid fa-book-bookmark"></i> Seller Center</span>
                <h3 class="section-title fs-3 mb-0">Books You've Listed ({{ $books->total() }})</h3>
            </div>
            <a href="{{ route('books.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> List Another Book
            </a>
        </div>

        <div class="row g-4">
            @forelse($books as $book)
                <div class="col-md-6 col-lg-4">
                    <div class="book-card">
                        <div class="book-card-image-wrapper" style="height: 220px;">
                            <img src="{{ $book->image }}" alt="{{ $book->title }}" class="book-card-image">
                            <span class="book-badge-condition">{{ $book->condition ?? 'Good' }}</span>
                            @if($book->category)
                                <span class="book-badge-category">{{ $book->category->name }}</span>
                            @endif
                        </div>
                        <div class="book-card-body">
                            <h4 class="book-title fs-6">
                                <a href="{{ route('books.show', $book->id) }}">{{ $book->title }}</a>
                            </h4>
                            <div class="book-author">
                                <i class="fa-solid fa-pen-nib"></i> {{ $book->author }}
                            </div>

                            <div class="book-meta-row mb-3">
                                <div>
                                    <span class="book-price-label">Price / Value</span>
                                    <span class="book-price-value">₹{{ number_format($book->price, 0) }}</span>
                                </div>
                                <span class="badge bg-success bg-opacity-10 text-success">
                                    <i class="fa-solid fa-circle-check me-1"></i> Active Listing
                                </span>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1" target="_blank">
                                    <i class="fa-solid fa-eye me-1"></i> View Live
                                </a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this book listing?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Remove Listing">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-white my-3">
                        <div class="mb-3 text-primary" style="font-size: 52px;">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <h4 class="fw-bold mb-2">You haven't listed any books yet</h4>
                        <p class="text-muted mb-4 max-w-500 mx-auto">
                            Have completed novels, school textbooks, or college engineering materials at home? List them now to exchange with fellow students or sell at fair INR (₹) prices!
                        </p>
                        <div>
                            <a href="{{ route('books.create') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
                                <i class="fa-solid fa-plus me-2"></i> List Your First Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>

@endsection
