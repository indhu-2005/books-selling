@extends('layouts.app')

@section('title', 'Reading Insights & Literary Blog - BooksApp')

@section('content')

<!-- Page Header Banner -->
<section class="page-header-banner">
    <div class="container text-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Blog</li>
            </ol>
        </nav>
        <h1 class="page-header-title">The BooksApp Reader's Journal</h1>
        <p class="page-header-desc">
            Tips on sustainable book swapping, curated reading recommendations, student study strategies, and the magic of physical literature.
        </p>

        <!-- Blog Search Input -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 col-lg-5">
                <form action="{{ route('blog') }}" method="GET" class="position-relative">
                    <input
                        type="text"
                        name="search"
                        class="form-control form-control-lg rounded-pill px-4 shadow-sm"
                        placeholder="Search blog articles..."
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
        <!-- Category Filter Pills -->
        <div class="d-flex align-items-center gap-2 overflow-auto pb-3 mb-4 border-bottom">
            <a href="{{ route('blog') }}" class="category-pill {{ !$category ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group"></i> All Topics
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog', ['category' => $cat]) }}" class="category-pill {{ $category === $cat ? 'active' : '' }}">
                    <i class="fa-solid fa-bookmark"></i> {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Featured Post Hero (if not searching) -->
        @if(!$search && !$category && $featuredPost)
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5 bg-white">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <img src="{{ $featuredPost->image }}" alt="{{ $featuredPost->title }}" class="img-fluid h-100 w-100" style="min-height: 320px; object-fit: cover;">
                    </div>
                    <div class="col-lg-6 p-4 p-md-5 d-flex flex-column justify-content-center">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-primary text-white">{{ $featuredPost->category }}</span>
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> {{ $featuredPost->read_time }}</span>
                        </div>
                        <h2 class="display-6 fs-3 fw-bold text-dark mb-3">
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="text-dark text-decoration-none hover-primary">
                                {{ $featuredPost->title }}
                            </a>
                        </h2>
                        <p class="text-muted lh-base mb-4">
                            {{ $featuredPost->excerpt }}
                        </p>
                        <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                            <div class="small text-muted">
                                By <strong class="text-dark">{{ $featuredPost->author_name }}</strong> • {{ \Carbon\Carbon::parse($featuredPost->published_at)->format('M d, Y') }}
                            </div>
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                Read Full Article <i class="fa-solid fa-arrow-right small ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Articles Grid -->
        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <img src="{{ $post->image }}" alt="{{ $post->title }}" class="blog-card-img">
                        <div class="blog-card-body">
                            <div class="blog-card-meta">
                                <span class="badge bg-info bg-opacity-10 text-primary fw-semibold">{{ $post->category }}</span>
                                <span><i class="fa-regular fa-clock me-1"></i> {{ $post->read_time }}</span>
                            </div>
                            <h4 class="blog-card-title">
                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                            </h4>
                            <p class="small text-muted mb-4 lh-base">
                                {{ Str::limit($post->excerpt, 110) }}
                            </p>
                            <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center small text-muted">
                                <span>{{ $post->author_name }}</span>
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-primary fw-semibold text-decoration-none">
                                    Read More →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No blog articles found matching your criteria.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>

@endsection
