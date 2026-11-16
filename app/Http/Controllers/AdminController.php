<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show Admin Login Page
     */
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Authenticate Admin User
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if (!$user->is_admin) {
                Auth::logout();
                return redirect()->route('admin.login')
                    ->with('error', 'Access denied. Administrator privileges required.');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', "Welcome back, {$user->name}! Admin control active.");
        }

        return back()->withErrors([
            'email' => 'The provided administrator credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Admin Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Logged out successfully from Admin Panel.');
    }

    /**
     * Admin Dashboard Overview
     */
    public function dashboard()
    {
        $totalBooks = Book::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'completed')->sum('amount');
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalRegistrations = EventRegistration::count();

        $recentOrders = Order::with('book')->latest()->take(6)->get();
        $recentBooks = Book::with('category')->latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalOrders',
            'totalRevenue',
            'totalUsers',
            'totalEvents',
            'totalRegistrations',
            'recentOrders',
            'recentBooks'
        ));
    }

    /**
     * Books Management Table
     */
    public function books(Request $request)
    {
        $search = $request->input('search');
        $categorySlug = $request->input('category');

        $query = Book::with(['category', 'authorProfile']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%");
            });
        }

        if ($categorySlug) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $books = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('admin.books.index', compact('books', 'categories', 'search', 'categorySlug'));
    }

    /**
     * Show Form to Add New Book
     */
    public function createBook()
    {
        $book = new Book();
        $categories = Category::all();
        $authors = Author::orderBy('name')->get();

        return view('admin.books.form', compact('book', 'categories', 'authors'));
    }

    /**
     * Store New Book
     */
    public function storeBook(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string|max:50',
            'image' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:50',
            'publisher' => 'nullable|string|max:150',
            'pages' => 'nullable|integer',
            'exchange_type' => 'nullable|string|max:50',
            'featured' => 'nullable|boolean',
            'rating' => 'nullable|numeric|between:1,5',
        ]);

        if (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id']);
            $validated['category_name'] = $category ? $category->name : null;
        }

        $validated['featured'] = $request->boolean('featured');
        $validated['is_exchangeable'] = true;

        if (empty($validated['image'])) {
            $validated['image'] = 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&auto=format&fit=crop&q=80';
        }

        Book::create($validated);

        return redirect()->route('admin.books')
            ->with('success', "Book '{$validated['title']}' added successfully!");
    }

    /**
     * Show Form to Edit Book
     */
    public function editBook($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        $authors = Author::orderBy('name')->get();

        return view('admin.books.form', compact('book', 'categories', 'authors'));
    }

    /**
     * Update Existing Book
     */
    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string|max:50',
            'image' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:50',
            'publisher' => 'nullable|string|max:150',
            'pages' => 'nullable|integer',
            'exchange_type' => 'nullable|string|max:50',
            'featured' => 'nullable|boolean',
            'rating' => 'nullable|numeric|between:1,5',
        ]);

        if (!empty($validated['category_id'])) {
            $category = Category::find($validated['category_id']);
            $validated['category_name'] = $category ? $category->name : null;
        }

        $validated['featured'] = $request->boolean('featured');

        $book->update($validated);

        return redirect()->route('admin.books')
            ->with('success', "Book '{$book->title}' updated successfully!");
    }

    /**
     * Delete Book
     */
    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $title = $book->title;
        $book->delete();

        return redirect()->route('admin.books')
            ->with('success', "Book '{$title}' removed successfully!");
    }

    /**
     * View Orders & Transactions
     */
    public function orders()
    {
        $orders = Order::with('book')->latest()->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    /**
     * Update Order Delivery / Payment Status
     */
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'delivery_status' => 'required|string|max:50',
            'payment_status' => 'required|string|max:50',
        ]);

        $order->update([
            'delivery_status' => $request->delivery_status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->back()->with('success', "Order #{$order->order_number} status updated!");
    }

    /**
     * View Event Registrations
     */
    public function eventRegistrations()
    {
        $registrations = EventRegistration::with('event')->latest()->paginate(15);
        return view('admin.events', compact('registrations'));
    }
}
