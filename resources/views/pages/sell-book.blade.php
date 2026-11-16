@extends('layouts.app')

@section('title', 'List a Book for Exchange or Sale - Seller Portal')

@section('content')

<!-- Header Banner -->
<section class="page-header-banner">
    <div class="container text-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('books') }}">Books</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">List a Book</li>
            </ol>
        </nav>
        <h1 class="page-header-title">List Your Book for Swap or Sale</h1>
        <p class="page-header-desc">
            Turn your read books, college textbooks, and novels into cash or exciting new reads. Connect directly with students and book lovers across Tamil Nadu and India.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container max-w-900">
        <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 bg-white">
            <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary fw-bold text-uppercase px-3 py-2 rounded-pill mb-1">
                        <i class="fa-solid fa-arrows-rotate me-1"></i> Seller & Student Exchange Form
                    </span>
                    <h3 class="fw-bold text-dark mb-0">Book & Listing Details</h3>
                </div>
                <a href="{{ route('books.my') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-book-bookmark me-1"></i> My Listed Books
                </a>
            </div>

            <form action="{{ route('books.store') }}" method="POST">
                @csrf

                <!-- Section 1: Book Details -->
                <h6 class="fw-bold text-dark text-uppercase small mb-3">
                    <i class="fa-solid fa-book text-primary me-1"></i> 1. Book Information
                </h6>

                <div class="row g-3 mb-4">
                    <div class="col-md-8">
                        <label class="form-label small fw-bold text-muted text-uppercase">Book Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Ponniyin Selvan / Higher Engineering Mathematics" value="{{ old('title') }}">
                        @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Price / Value (₹ INR) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">₹</span>
                            <input type="number" step="0.01" name="price" class="form-control" required placeholder="250.00" value="{{ old('price') }}">
                        </div>
                        @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Author Name <span class="text-danger">*</span></label>
                        <input type="text" name="author" class="form-control" required placeholder="e.g. Kalki Krishnamurthy / Dr. B.S. Grewal" value="{{ old('author') }}">
                        @error('author') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Condition <span class="text-danger">*</span></label>
                        <select name="condition" class="form-select" required>
                            <option value="Brand New">Brand New (Unopened / Mint)</option>
                            <option value="Like New" selected>Like New (Clean pages, no marks)</option>
                            <option value="Very Good">Very Good (Minimal shelf wear)</option>
                            <option value="Good">Good (Intact spine & pages)</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Language</label>
                        <input type="text" name="language" class="form-control" placeholder="Tamil, English, etc." value="{{ old('language', 'Tamil & English') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Listing Intent</label>
                        <select name="exchange_type" class="form-select">
                            <option value="Buy / Exchange" selected>Both (Direct Swap or Buy)</option>
                            <option value="Direct Swap Only">Direct Swap Only</option>
                            <option value="Sale Only">Sale Only</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Book Cover Photo URL (Optional)</label>
                        <input type="url" name="image" class="form-control" placeholder="https://images.unsplash.com/photo-..." value="{{ old('image') }}">
                        <div class="form-text small">Leave blank to use a default quality book cover.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Description & Highlights</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe the edition, highlights, reason for exchange, or syllabus details...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Section 2: Seller Contact Details -->
                <h6 class="fw-bold text-dark text-uppercase small mb-3 pt-3 border-top">
                    <i class="fa-solid fa-id-card text-primary me-1"></i> 2. Seller Contact & Location (Tamil Nadu / India)
                </h6>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Your Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="seller_name" class="form-control" required placeholder="e.g. Indhumathi" value="{{ old('seller_name', $user->name ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">WhatsApp / Mobile Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">+91</span>
                            <input type="tel" name="seller_phone" class="form-control" required placeholder="9876543210" pattern="[0-9]{10}" maxlength="10" value="{{ old('seller_phone') }}">
                        </div>
                        <div class="form-text small">Interested buyers & swappers can message you.</div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">City / Campus Location <span class="text-danger">*</span></label>
                        <input type="text" name="seller_city" class="form-control" required placeholder="e.g. Chennai, Coimbatore, Madurai" value="{{ old('seller_city', 'Chennai') }}">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-3 border-top">
                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold shadow">
                        <i class="fa-solid fa-cloud-arrow-up me-2"></i> Publish Book to Exchange Catalog
                    </button>
                    <div class="text-center small text-muted mt-2">
                        <i class="fa-solid fa-shield-halved text-success me-1"></i> Your listing will be visible immediately to all community readers across India.
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
