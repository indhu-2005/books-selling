<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        $search = $request->input('search');

        $query = BlogPost::latest('published_at');

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
                  ->orWhere('author_name', 'LIKE', "%{$search}%");
            });
        }

        $posts = $query->paginate(6)->withQueryString();
        $categories = BlogPost::select('category')->distinct()->pluck('category');
        $featuredPost = BlogPost::latest('published_at')->first();

        return view('pages.blog', compact('posts', 'categories', 'category', 'search', 'featuredPost'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        $relatedPosts = BlogPost::where('id', '!=', $post->id)->take(3)->get();

        return view('pages.blog-detail', compact('post', 'relatedPosts'));
    }
}
