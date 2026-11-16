<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel - @yield('title', 'Control Dashboard')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

    <style>
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: #0f172a;
            color: #cbd5e1;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            flex-direction: column;
        }
        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }
        .admin-nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
            border-left-color: #38bdf8;
        }
        .admin-nav-link.active {
            color: #ffffff;
            background-color: #2563eb;
            border-left-color: #38bdf8;
            font-weight: 600;
        }
        .admin-main-content {
            margin-left: 260px;
            min-height: 100vh;
            background-color: #f8fafc;
            display: flex;
            flex-direction: column;
        }
        .admin-topbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 90;
        }
        @media (max-width: 991px) {
            .admin-sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }
            .admin-main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <div class="d-flex flex-column flex-lg-row">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="p-4 border-bottom border-white border-opacity-10 d-flex align-items-center justify-content-between">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-white text-decoration-none fw-bold fs-5">
                    <div class="brand-icon-box" style="width:34px; height:34px; font-size:16px;">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <span>Books<span class="text-info">Admin</span></span>
                </a>
            </div>

            <div class="py-3 flex-grow-1">
                <div class="px-3 mb-2 small text-uppercase text-muted fw-bold letter-spacing-1">Overview</div>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>

                <div class="px-3 mt-4 mb-2 small text-uppercase text-muted fw-bold letter-spacing-1">Catalog Management</div>
                <a href="{{ route('admin.books') }}" class="admin-nav-link {{ request()->routeIs('admin.books*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book"></i>
                    <span>Manage Books</span>
                </a>
                <a href="{{ route('admin.books.create') }}" class="admin-nav-link {{ request()->routeIs('admin.books.create') ? 'active' : '' }}">
                    <i class="fa-solid fa-square-plus text-info"></i>
                    <span>Add New Book</span>
                </a>

                <div class="px-3 mt-4 mb-2 small text-uppercase text-muted fw-bold letter-spacing-1">Operations</div>
                <a href="{{ route('admin.orders') }}" class="admin-nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Orders & Payments</span>
                </a>
                <a href="{{ route('admin.events') }}" class="admin-nav-link {{ request()->routeIs('admin.events*') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span>Event RSVPs</span>
                </a>
            </div>

            <!-- Sidebar Bottom Info -->
            <div class="p-3 border-top border-white border-opacity-10">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:32px; height:32px; font-size:13px;">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div class="small text-truncate">
                        <strong class="text-white d-block">{{ auth()->user()->name ?? 'Administrator' }}</strong>
                        <span class="text-muted" style="font-size:11px;">Admin Role</span>
                    </div>
                </div>
                <div class="d-grid gap-1 mt-2">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light text-start py-1" style="font-size:12px;">
                        <i class="fa-solid fa-globe me-1"></i> Visit Public Site
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="admin-main-content flex-grow-1">
            <!-- Topbar -->
            <header class="admin-topbar">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="fw-bold text-dark mb-0">@yield('page_title', 'Control Center')</h5>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3" target="_blank">
                        <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Live Website
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                            <i class="fa-solid fa-power-off me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Flash Alerts -->
            <div class="p-4 pb-0">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                        <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                        <i class="fa-solid fa-circle-exclamation fs-5 me-2 text-danger"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>

            <!-- Page Body -->
            <main class="p-4 flex-grow-1">
                @yield('content')
            </main>

            <!-- Admin Footer -->
            <footer class="p-3 bg-white border-top text-center small text-muted">
                BooksApp Admin Management Portal • 100% Indian Currency (INR ₹) Transactions
            </footer>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
