<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\BlogPost;
use App\Models\Book;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Home Page View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categorySlug = $request->input('category');

        try {
            $query = Book::with(['category', 'authorProfile']);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('author', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%")
                      ->orWhereHas('category', function ($catQuery) use ($search) {
                          $catQuery->where('name', 'LIKE', "%{$search}%");
                      });
                });
            }

            if ($categorySlug) {
                $query->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            }

            $featuredBooks = (clone $query)->where('featured', true)->latest()->take(4)->get();
            if ($featuredBooks->isEmpty()) {
                $featuredBooks = (clone $query)->latest()->take(4)->get();
            }

            $recentBooks = (clone $query)->latest()->take(8)->get();
            $categories = Category::withCount('books')->get();
            $upcomingEvents = Event::where('event_date', '>=', now()->toDateString())
                                    ->orderBy('event_date', 'asc')
                                    ->take(3)
                                    ->get();
            $recentPosts = BlogPost::latest()->take(3)->get();
            $authorsCount = Author::count();
            $booksCount = Book::count();
        } catch (\Throwable $e) {
            // Graceful fallback when database connection is not yet configured on serverless
            $featuredBooks = collect([]);
            $recentBooks = collect([]);
            $categories = collect([]);
            $upcomingEvents = collect([]);
            $recentPosts = collect([]);
            $authorsCount = 0;
            $booksCount = 0;
        }

        return view('pages.home', compact(
            'featuredBooks',
            'recentBooks',
            'categories',
            'upcomingEvents',
            'recentPosts',
            'search',
            'categorySlug',
            'authorsCount',
            'booksCount'
        ));
    }

    /**
     * Dedicated Books Catalog Page with full filtering and sorting
     */
    public function catalog(Request $request)
    {
        $search = $request->input('search');
        $categorySlug = $request->input('category');
        $authorSlug = $request->input('author');
        $condition = $request->input('condition');
        $sort = $request->input('sort', 'latest');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $query = Book::with(['category', 'authorProfile']);

        // Search in title, author, description, category
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function ($catQuery) use ($search) {
                      $catQuery->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Category filter
        if ($categorySlug && $categorySlug !== 'all') {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Author filter
        if ($authorSlug) {
            $query->where(function ($q) use ($authorSlug) {
                $q->whereHas('authorProfile', function ($authQuery) use ($authorSlug) {
                    $authQuery->where('slug', $authorSlug);
                })->orWhere('author', 'LIKE', "%{$authorSlug}%");
            });
        }

        // Condition filter
        if ($condition && $condition !== 'all') {
            $query->where('condition', $condition);
        }

        // Price filters
        if ($minPrice !== null && is_numeric($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null && is_numeric($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }

        // Sorting
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $books = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('books')->get();
        $authors = Author::orderBy('name')->get();
        $selectedCategory = $categorySlug ? Category::where('slug', $categorySlug)->first() : null;

        return view('pages.books', compact(
            'books',
            'categories',
            'authors',
            'search',
            'categorySlug',
            'selectedCategory',
            'authorSlug',
            'condition',
            'sort',
            'minPrice',
            'maxPrice'
        ));
    }

    /**
     * Book Detail View
     */
    public function show($id)
    {
        $book = Book::with(['category', 'authorProfile'])->findOrFail($id);

        $relatedBooks = Book::where('id', '!=', $book->id)
            ->where(function ($q) use ($book) {
                if ($book->category_id) {
                    $q->where('category_id', $book->category_id);
                }
            })
            ->take(4)
            ->get();

        if ($relatedBooks->isEmpty()) {
            $relatedBooks = Book::where('id', '!=', $book->id)->take(4)->get();
        }

        return view('pages.book-detail', compact('book', 'relatedBooks'));
    }

    /**
     * Live Dynamic Search API (JSON)
     */
    public function searchApi(Request $request)
    {
        $q = trim($request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json([
                'books' => [],
                'authors' => [],
                'categories' => [],
            ]);
        }

        $books = Book::where('title', 'LIKE', "%{$q}%")
            ->orWhere('author', 'LIKE', "%{$q}%")
            ->select('id', 'title', 'author', 'price', 'image', 'condition')
            ->take(5)
            ->get();

        $authors = Author::where('name', 'LIKE', "%{$q}%")
            ->select('id', 'name', 'slug', 'genre')
            ->take(3)
            ->get();

        $categories = Category::where('name', 'LIKE', "%{$q}%")
            ->select('id', 'name', 'slug', 'icon')
            ->take(3)
            ->get();

        return response()->json([
            'books' => $books,
            'authors' => $authors,
            'categories' => $categories,
        ]);
    }

    /**
     * Show Form to List a Book for Exchange or Sale (Seller)
     */
    public function create()
    {
        $categories = Category::all();
        $user = Auth::user();
        return view('pages.sell-book', compact('categories', 'user'));
    }

    /**
     * Store Book Listed by Seller / User
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'condition' => 'required|string|in:Brand New,Like New,Very Good,Good',
            'seller_name' => 'required|string|max:100',
            'seller_phone' => 'required|string|max:15',
            'seller_city' => 'required|string|max:100',
            'language' => 'nullable|string|max:50',
            'image' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'exchange_type' => 'nullable|string',
        ]);

        $category = Category::find($validated['category_id']);
        $validated['category_name'] = $category ? $category->name : 'General';
        $validated['user_id'] = Auth::id();
        $validated['is_exchangeable'] = true;
        $validated['featured'] = false;
        $validated['rating'] = 4.8;

        if (empty($validated['image'])) {
            $validated['image'] = 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&auto=format&fit=crop&q=80';
        }

        $book = Book::create($validated);

        return redirect()->route('books.show', $book->id)
            ->with('success', "Congratulations! '{$book->title}' has been listed successfully for exchange & sale.");
    }

    /**
     * View Books Listed by Logged-in User
     */
    public function myBooks()
    {
        $books = Book::where('user_id', Auth::id())->latest()->paginate(10);
        return view('pages.my-books', compact('books'));
    }

    /**
     * Delete Book Listed by User
     */
    public function destroyUserBook($id)
    {
        $book = Book::where('id', $id)
            ->where(function ($q) {
                $q->where('user_id', Auth::id())
                  ->orWhereRaw('? = 1', [Auth::user()->is_admin ? 1 : 0]);
            })
            ->firstOrFail();

        $title = $book->title;
        $book->delete();

        return redirect()->back()->with('success', "'{$title}' has been removed from your listings.");
    }
}
