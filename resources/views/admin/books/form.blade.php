@extends('admin.layout')

@section('title', $book->exists ? 'Edit Book - ' . $book->title : 'Add New Book')
@section('page_title', $book->exists ? 'Edit Book Details' : 'Add Book to Exchange Catalog')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-book-open text-primary me-2"></i>
                    {{ $book->exists ? 'Edit Book #' . $book->id : 'Create New Book Listing' }}
                </h5>
                <a href="{{ route('admin.books') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Catalog
                </a>
            </div>

            <form action="{{ $book->exists ? route('admin.books.update', $book->id) : route('admin.books.store') }}" method="POST">
                @csrf
                @if($book->exists)
                    @method('PUT')
                @endif

                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-md-8">
                        <label class="form-label small fw-bold text-muted text-uppercase">Book Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Ponniyin Selvan / Higher Engineering Mathematics" value="{{ old('title', $book->title) }}">
                        @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Price in INR -->
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Exchange Value / Price (₹ INR) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold">₹</span>
                            <input type="number" step="0.01" name="price" class="form-control" required placeholder="299.00" value="{{ old('price', $book->price) }}">
                        </div>
                        @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Author -->
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Author Name <span class="text-danger">*</span></label>
                        <input type="text" name="author" class="form-control" required placeholder="e.g. Kalki Krishnamurthy / Dr. A.P.J. Abdul Kalam" value="{{ old('author', $book->author) }}">
                        @error('author') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted text-uppercase">Category</label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Condition -->
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Condition <span class="text-danger">*</span></label>
                        <select name="condition" class="form-select" required>
                            <option value="Brand New" {{ old('condition', $book->condition) === 'Brand New' ? 'selected' : '' }}>Brand New (Unopened)</option>
                            <option value="Like New" {{ old('condition', $book->condition) === 'Like New' ? 'selected' : '' }}>Like New (Clean spine)</option>
                            <option value="Very Good" {{ old('condition', $book->condition) === 'Very Good' ? 'selected' : '' }}>Very Good (Minimal wear)</option>
                            <option value="Good" {{ old('condition', $book->condition) === 'Good' ? 'selected' : '' }}>Good (Intact pages)</option>
                        </select>
                    </div>

                    <!-- Language -->
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Language</label>
                        <input type="text" name="language" class="form-control" placeholder="English, Tamil, etc." value="{{ old('language', $book->language ?? 'English') }}">
                    </div>

                    <!-- Rating -->
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Rating (1.0 to 5.0)</label>
                        <input type="number" step="0.1" min="1" max="5" name="rating" class="form-control" placeholder="4.8" value="{{ old('rating', $book->rating ?? 4.8) }}">
                    </div>

                    <!-- Image URL -->
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Book Cover Image URL</label>
                        <input type="url" name="image" class="form-control" placeholder="https://images.unsplash.com/photo-..." value="{{ old('image', $book->image) }}">
                        <div class="form-text small">Provide a direct high-resolution image URL for the book cover.</div>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label small fw-bold text-muted text-uppercase">Book Overview & Condition Notes</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Detailed summary of the book, subject relevance, and physical condition details...">{{ old('description', $book->description) }}</textarea>
                    </div>

                    <!-- ISBN -->
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">ISBN</label>
                        <input type="text" name="isbn" class="form-control" placeholder="978-81-..." value="{{ old('isbn', $book->isbn) }}">
                    </div>

                    <!-- Publisher -->
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Publisher</label>
                        <input type="text" name="publisher" class="form-control" placeholder="e.g. Vanathi Pathippagam" value="{{ old('publisher', $book->publisher) }}">
                    </div>

                    <!-- Total Pages -->
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Total Pages</label>
                        <input type="number" name="pages" class="form-control" placeholder="320" value="{{ old('pages', $book->pages) }}">
                    </div>

                    <!-- Featured Checkbox -->
                    <div class="col-12 mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="featured" id="featuredSwitch" value="1" {{ old('featured', $book->featured) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark" for="featuredSwitch">
                                Feature this book prominently on the Home Page
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 fw-bold">
                        <i class="fa-solid fa-floppy-disk me-1"></i> {{ $book->exists ? 'Update Book' : 'Save Book to Catalog' }}
                    </button>
                    <a href="{{ route('admin.books') }}" class="btn btn-outline-secondary px-3">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
