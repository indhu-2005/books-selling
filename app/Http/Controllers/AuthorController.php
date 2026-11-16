<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Author::withCount('books');

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('genre', 'LIKE', "%{$search}%")
                  ->orWhere('nationality', 'LIKE', "%{$search}%");
        }

        $authors = $query->orderBy('name')->paginate(12)->withQueryString();
        $genres = Author::select('genre')->distinct()->pluck('genre');

        return view('pages.authors', compact('authors', 'search', 'genres'));
    }

    public function show($slug)
    {
        $author = Author::with(['books' => function ($q) {
            $q->with('category');
        }])->where('slug', $slug)->firstOrFail();

        return view('pages.author-detail', compact('author'));
    }
}
