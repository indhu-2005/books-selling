@extends('admin.layout')

@section('title', 'Admin Dashboard Overview')
@section('page_title', 'Platform Performance & Operations')

@section('content')

<!-- Stat Metrics Cards -->
<div class="row g-3 mb-4">
    <!-- Stat 1: Total Books -->
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="small text-muted text-uppercase fw-bold">Exchange Books</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $totalBooks }}</h3>
                    <span class="small text-success"><i class="fa-solid fa-arrow-up"></i> Active in Catalog</span>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 22px;">
                    <i class="fa-solid fa-book"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2: Total Orders -->
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="small text-muted text-uppercase fw-bold">Customer Orders</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $totalOrders }}</h3>
                    <span class="small text-primary"><i class="fa-solid fa-bag-shopping"></i> Total Completed</span>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 22px;">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3: Total Revenue in INR -->
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="small text-muted text-uppercase fw-bold">Total Sales (INR)</span>
                    <h3 class="fw-bold text-primary mb-0 mt-1">₹{{ number_format($totalRevenue, 0) }}</h3>
                    <span class="small text-muted">Via UPI, Cards & Net Banking</span>
                </div>
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 22px;">
                    <i class="fa-solid fa-indian-rupee-sign"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4: Registered Users -->
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="small text-muted text-uppercase fw-bold">Community Users</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $totalUsers }}</h3>
                    <span class="small text-muted">Registered accounts</span>
                </div>
                <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 22px;">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 5: Events -->
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="small text-muted text-uppercase fw-bold">Event Meets</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $totalEvents }}</h3>
                    <span class="small text-muted">Book swap drives scheduled</span>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 22px;">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 6: Event RSVPs -->
    <div class="col-sm-6 col-xl-4">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="small text-muted text-uppercase fw-bold">Event RSVPs</span>
                    <h3 class="fw-bold text-dark mb-0 mt-1">{{ $totalRegistrations }}</h3>
                    <span class="small text-success">Attendee registrations</span>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; font-size: 22px;">
                    <i class="fa-solid fa-ticket"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Shortcuts -->
<div class="d-flex flex-wrap gap-2 mb-4">
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
        <i class="fa-solid fa-plus me-1"></i> Add New Book
    </a>
    <a href="{{ route('admin.books') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
        <i class="fa-solid fa-list me-1"></i> View All Books ({{ $totalBooks }})
    </a>
    <a href="{{ route('admin.orders') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
        <i class="fa-solid fa-receipt me-1"></i> Manage Orders ({{ $totalOrders }})
    </a>
</div>

<div class="row g-4">
    <!-- Recent Orders -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden h-100">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-receipt text-primary me-2"></i> Recent Orders & Transactions
                </h6>
                <a href="{{ route('admin.orders') }}" class="small text-primary text-decoration-none fw-semibold">View All →</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="bg-light text-muted text-uppercase">
                        <tr>
                            <th>Order No</th>
                            <th>Customer</th>
                            <th>Book</th>
                            <th>Amount</th>
                            <th>Mode</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td><span class="fw-bold text-dark">#{{ $order->order_number }}</span></td>
                                <td>{{ $order->customer_name }}</td>
                                <td class="text-truncate" style="max-width: 140px;">{{ $order->book->title ?? 'N/A' }}</td>
                                <td><strong class="text-primary">₹{{ number_format($order->amount, 0) }}</strong></td>
                                <td><span class="badge bg-light text-dark border">{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</span></td>
                                <td><span class="badge bg-success bg-opacity-10 text-success">{{ $order->delivery_status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No orders placed yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Books Added -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden h-100">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0">
                    <i class="fa-solid fa-book-bookmark text-primary me-2"></i> Recently Added Books
                </h6>
                <a href="{{ route('admin.books') }}" class="small text-primary text-decoration-none fw-semibold">Manage All →</a>
            </div>
            <div class="p-3">
                <div class="d-flex flex-column gap-3">
                    @forelse($recentBooks as $b)
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $b->image }}" alt="{{ $b->title }}" class="rounded shadow-sm flex-shrink-0" style="width: 44px; height: 58px; object-fit: cover;">
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="text-truncate fw-bold mb-0 text-dark small">{{ $b->title }}</h6>
                                <div class="text-muted small" style="font-size: 11px;">By {{ $b->author }} • <span class="badge bg-light text-dark">{{ $b->condition ?? 'Good' }}</span></div>
                            </div>
                            <div class="text-end flex-shrink-0">
                                <span class="fw-bold text-primary small">₹{{ number_format($b->price, 0) }}</span>
                                <a href="{{ route('admin.books.edit', $b->id) }}" class="btn btn-sm btn-outline-secondary py-0 px-2 d-block mt-1" style="font-size: 11px;">Edit</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No books added yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
