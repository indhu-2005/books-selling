<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class AboutController extends Controller
{
    public function index()
    {
        $booksCount = Book::count();
        $categoriesCount = Category::count();
        $authorsCount = Author::count();
        $usersCount = User::count();
        $ordersCount = Order::count();

        // Estimated metrics for sustainability and savings
        $treesSaved = max(14, intval($booksCount * 1.5));
        $rupeesSaved = max(45000, $booksCount * 320);

        return view('pages.about', compact(
            'booksCount',
            'categoriesCount',
            'authorsCount',
            'usersCount',
            'ordersCount',
            'treesSaved',
            'rupeesSaved'
        ));
    }
}
