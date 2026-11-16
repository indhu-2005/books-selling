@extends('layouts.app')

@section('title', $post->title . ' - BooksApp Journal')

@section('content')

<!-- Blog Header -->
<section class="py-4 bg-light border-bottom">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog') }}">Blog</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 350px;" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>
    </div>
</section>

<article class="py-5">
    <div class="container max-w-900">
        <!-- Title & Meta -->
        <div class="text-center mb-4">
            <span class="badge bg-primary px-3 py-2 rounded-pill mb-3">{{ $post->category }}</span>
            <h1 class="display-5 fw-bold text-dark mb-3">{{ $post->title }}</h1>
            <div class="d-flex justify-content-center align-items-center gap-3 text-muted small">
                <span>By <strong class="text-dark">{{ $post->author_name }}</strong></span>
                <span>•</span>
                <span><i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($post->published_at)->format('F j, Y') }}</span>
                <span>•</span>
                <span><i class="fa-regular fa-clock me-1"></i> {{ $post->read_time }}</span>
            </div>
        </div>

        <!-- Featured Banner Image -->
        <div class="rounded-4 overflow-hidden shadow-sm mb-5 text-center">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="img-fluid w-100" style="max-height: 480px; object-fit: cover;">
        </div>

        <!-- Article Body -->
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-5">
            <div class="lead fw-normal text-secondary mb-4 pb-3 border-bottom lh-base">
                {{ $post->excerpt }}
            </div>

            <div class="blog-post-content lh-lg text-dark fs-6" style="white-space: pre-line;">
                {{ $post->content }}
            </div>

            <!-- Share & Tags -->
            <div class="d-flex flex-wrap justify-content-between align-items-center pt-4 mt-4 border-top">
                <div class="d-flex align-items-center gap-2 mb-2 mb-sm-0">
                    <span class="small fw-bold text-muted text-uppercase">Share this article:</span>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-circle" style="width:34px; height:34px;"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-circle" style="width:34px; height:34px;"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-circle" style="width:34px; height:34px;"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <a href="{{ route('blog') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Blog
                </a>
            </div>
        </div>

        <!-- Related Posts -->
        @if($relatedPosts->count() > 0)
            <div class="pt-4">
                <h4 class="fw-bold text-dark mb-4">Related Reads</h4>
                <div class="row g-4">
                    @foreach($relatedPosts as $rel)
                        <div class="col-md-4">
                            <div class="blog-card">
                                <img src="{{ $rel->image }}" alt="{{ $rel->title }}" class="blog-card-img" style="height: 150px;">
                                <div class="blog-card-body p-3">
                                    <span class="badge bg-light text-primary small mb-1">{{ $rel->category }}</span>
                                    <h6 class="fw-bold mb-2">
                                        <a href="{{ route('blog.show', $rel->slug) }}" class="text-dark text-decoration-none hover-primary">
                                            {{ Str::limit($rel->title, 45) }}
                                        </a>
                                    </h6>
                                    <div class="small text-muted">{{ $rel->read_time }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>

@endsection
