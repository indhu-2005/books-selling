<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - BooksApp Control Center</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .admin-login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 440px;
            overflow: hidden;
        }
    </style>
</head>
<body>

    <div class="admin-login-card">
        <!-- Card Header -->
        <div class="p-4 p-md-5 pb-3 text-center bg-white">
            <div class="brand-icon-box mx-auto mb-3" style="width: 52px; height: 52px; font-size: 24px;">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h3 class="fw-bold text-dark mb-1">Admin Portal</h3>
            <p class="small text-muted mb-0">Sign in to manage books, orders & platform activity</p>
        </div>

        <!-- Form Body -->
        <div class="p-4 p-md-5 pt-0">
            @if(session('error'))
                <div class="alert alert-danger small py-2 d-flex align-items-center mb-3">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success small py-2 d-flex align-items-center mb-3">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Admin Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required
                            placeholder="admin@booksapp.com"
                            value="{{ old('email', 'admin@booksapp.com') }}"
                            id="admin_email"
                        >
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fa-solid fa-key text-muted"></i></span>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required
                            placeholder="••••••••"
                            value="admin123"
                            id="admin_password"
                        >
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 small">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                        <label class="form-check-label text-muted" for="rememberMe">
                            Remember session
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold shadow">
                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i> Access Admin Dashboard
                </button>
            </form>

            <!-- Demo Admin Info Box -->
            <div class="mt-4 p-3 bg-light rounded-3 border small">
                <div class="fw-bold text-dark mb-1 d-flex align-items-center gap-1">
                    <i class="fa-solid fa-circle-info text-primary"></i> Default Admin Credentials:
                </div>
                <div class="text-muted">
                    Email: <code class="text-primary fw-bold">admin@booksapp.com</code><br>
                    Password: <code class="text-primary fw-bold">admin123</code>
                </div>
                <div class="mt-2 pt-2 border-top text-secondary small">
                    *Existing account <code>indhukarthi22005@gmail.com</code> also has full admin access.
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="small text-muted text-decoration-none hover-primary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Public Website
                </a>
            </div>
        </div>
    </div>

</body>
</html>
