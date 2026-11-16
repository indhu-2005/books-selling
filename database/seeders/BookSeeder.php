<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book; 

class BookSeeder extends Seeder
{
    public function run()
    {
        for($i=1; $i<=8; $i++){
            Book::create([
                'title' => "Sample Book Title $i",
                'author' => "Author Name $i",
                'price' => rand(10, 50) * 10,
                'image' => "https://covers.openlibrary.org/b/id/" . (8000000 + $i) . "-L.jpg",
                'description' => "This is a dummy description for book $i."
            ]);
        }
    }
}