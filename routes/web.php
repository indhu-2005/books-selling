<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - BooksApp (Book Exchange Platform)
|--------------------------------------------------------------------------
*/

// Home & Catalog
Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/books', [BookController::class, 'catalog'])->name('books');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/api/search', [BookController::class, 'searchApi'])->name('api.search');

// User / Seller Book Listing
Route::middleware('auth')->group(function () {
    Route::get('/sell-book', [BookController::class, 'create'])->name('books.create');
    Route::post('/sell-book', [BookController::class, 'store'])->name('books.store');
    Route::get('/my-books', [BookController::class, 'myBooks'])->name('books.my');
    Route::delete('/my-books/{id}', [BookController::class, 'destroyUserBook'])->name('books.destroy');
});

// Authors
Route::get('/authors', [AuthorController::class, 'index'])->name('authors');
Route::get('/authors/{slug}', [AuthorController::class, 'show'])->name('authors.show');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events');
Route::post('/events/{id}/register', [EventController::class, 'register'])->name('events.register');

// About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Indian Payments & Checkout (Razorpay, UPI, Cards, Net Banking)
Route::get('/payment/{id}', [PaymentController::class, 'checkout'])->name('payment');
Route::post('/payment/process/{id}', [PaymentController::class, 'process'])->name('payment.process');
Route::post('/payment/razorpay/create-order', [PaymentController::class, 'createRazorpayOrder'])->name('payment.razorpay.create');
Route::get('/payment/success/{id}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');

// Admin Authentication Routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Protected Admin Panel Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/books', [AdminController::class, 'books'])->name('books');
    Route::get('/books/create', [AdminController::class, 'createBook'])->name('books.create');
    Route::post('/books', [AdminController::class, 'storeBook'])->name('books.store');
    Route::get('/books/{id}/edit', [AdminController::class, 'editBook'])->name('books.edit');
    Route::put('/books/{id}', [AdminController::class, 'updateBook'])->name('books.update');
    Route::delete('/books/{id}', [AdminController::class, 'deleteBook'])->name('books.delete');

    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    Route::get('/events', [AdminController::class, 'eventRegistrations'])->name('events');
});

// Dashboard Redirect
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('home')->with('success', 'Welcome back!');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth Routes (Login, Register, Logout, Password Reset)
require __DIR__.'/auth.php';
