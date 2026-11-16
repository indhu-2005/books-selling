@extends('layouts.app')

@section('title', 'Featured Authors - BooksApp Community')

@section('content')

<!-- Page Header Banner -->
<section class="page-header-banner">
    <div class="container text-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Authors</li>
            </ol>
        </nav>
        <h1 class="page-header-title">Celebrated Authors & Thinkers</h1>
        <p class="page-header-desc">
            Explore renowned Indian and international literary figures whose books, memoirs, and educational texts are available in our community exchange catalog.
        </p>

        <!-- Author Search Input -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 col-lg-5">
                <form action="{{ route('authors') }}" method="GET" class="position-relative">
                    <input
                        type="text"
                        name="search"
                        class="form-control form-control-lg rounded-pill px-4 shadow-sm"
                        placeholder="Search author by name, genre..."
                        value="{{ $search }}"
                    >
                    <button type="submit" class="btn btn-primary rounded-pill position-absolute end-0 top-0 mt-1 me-1 px-4 py-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <!-- Results Header -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <span class="section-tag"><i class="fa-solid fa-feather-pointed"></i> Literary Creators</span>
                <h3 class="section-title fs-3 mb-0">Browse Authors</h3>
            </div>
            @if($search)
                <div>
                    <span class="badge bg-light text-dark border p-2">
                        Filtered by: "{{ $search }}"
                        <a href="{{ route('authors') }}" class="ms-1 text-danger"><i class="fa-solid fa-xmark"></i></a>
                    </span>
                </div>
            @endif
        </div>

        <div class="row g-4">
            @forelse($authors as $author)
                <div class="col-xl-4 col-md-6">
                    <div class="author-card">
                        <img src="{{ $author->photo }}" alt="{{ $author->name }}" class="author-photo">
                        <h4 class="author-name">
                            <a href="{{ route('authors.show', $author->slug) }}" class="text-dark text-decoration-none hover-primary">
                                {{ $author->name }}
                            </a>
                        </h4>
                        <div class="author-genre">
                            <i class="fa-solid fa-bookmark me-1 small"></i> {{ $author->genre }}
                        </div>
                        <p class="author-bio">
                            {{ $author->bio }}
                        </p>
                        <div class="mt-auto w-100 pt-3 border-top d-flex align-items-center justify-content-between">
                            <span class="small text-muted fw-semibold">
                                <i class="fa-solid fa-book-open text-primary me-1"></i> {{ $author->books_count }} Books in Exchange
                            </span>
                            <a href="{{ route('books', ['author' => $author->slug]) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                View Books <i class="fa-solid fa-arrow-right small ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 bg-white rounded-4 shadow-sm border">
                        <i class="fa-solid fa-user-slash text-muted mb-3" style="font-size: 44px;"></i>
                        <h4 class="fw-bold">No authors found</h4>
                        <p class="text-muted">No authors matching "{{ $search }}". Try another query or clear search.</p>
                        <a href="{{ route('authors') }}" class="btn btn-primary px-4 mt-2">Clear Search</a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $authors->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>

@endsection
