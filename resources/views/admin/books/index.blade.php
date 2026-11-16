@extends('admin.layout')

@section('title', 'Manage Books')
@section('page_title', 'Books Catalog Management')

@section('content')

<!-- Header & Add Button -->
<div class="card border-0 shadow-sm rounded-4 bg-white p-3 mb-4">
    <div class="row align-items-center g-3">
        <div class="col-md-6">
            <form action="{{ route('admin.books') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search title or author..." value="{{ $search }}">
                <select name="category" class="form-select form-select-sm" style="max-width: 180px;">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ $categorySlug === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm px-3">Filter</button>
                @if($search || $categorySlug)
                    <a href="{{ route('admin.books') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                @endif
            </form>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.books.create') }}" class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Add New Book
            </a>
        </div>
    </div>
</div>

<!-- Books Table -->
<div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="bg-light text-muted text-uppercase">
                <tr>
                    <th style="width: 60px;">Cover</th>
                    <th>Title & Author</th>
                    <th>Category</th>
                    <th>Condition</th>
                    <th>Price (INR)</th>
                    <th>Featured</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>
                            <img src="{{ $book->image }}" alt="{{ $book->title }}" class="rounded shadow-sm" style="width: 42px; height: 56px; object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $book->title }}</div>
                            <div class="text-muted small">by {{ $book->author }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $book->category_name ?? ($book->category->name ?? 'General') }}</span>
                        </td>
                        <td>
                            <span class="badge bg-primary bg-opacity-10 text-primary">{{ $book->condition ?? 'Good' }}</span>
                        </td>
                        <td>
                            <strong class="text-primary fs-6">₹{{ number_format($book->price, 0) }}</strong>
                        </td>
                        <td>
                            @if($book->featured)
                                <span class="badge bg-success bg-opacity-10 text-success"><i class="fa-solid fa-star me-1"></i> Featured</span>
                            @else
                                <span class="text-muted small">Standard</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-secondary" target="_blank" title="View Live">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-outline-primary" title="Edit Book">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.books.delete', $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this book from the catalog?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete Book">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No books found matching criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-3 border-top d-flex justify-content-center">
        {{ $books->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
