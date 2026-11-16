<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TamilNaduBooksSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Add Iconic Tamil Authors
        $kalki = Author::firstOrCreate(
            ['slug' => 'kalki-krishnamurthy'],
            [
                'name' => 'Kalki Krishnamurthy',
                'genre' => 'Tamil Historical Fiction, Classics',
                'nationality' => 'Indian (Tamil Nadu)',
                'bio' => 'Celebrated Tamil writer, journalist, and freedom fighter, best known for monumental historical epics like Ponniyin Selvan, Sivagamiyin Sabatham, and Parthiban Kanavu.',
                'photo' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?w=400&auto=format&fit=crop&q=80',
            ]
        );

        $thiruvalluvar = Author::firstOrCreate(
            ['slug' => 'thiruvalluvar'],
            [
                'name' => 'Thiruvalluvar',
                'genre' => 'Classical Tamil Ethics & Philosophy',
                'nationality' => 'Indian (Tamil Nadu)',
                'bio' => 'Celebrated ancient Tamil poet and philosopher, author of the Tirukkural, a masterpiece of 1,330 couplets on virtue, wealth, and love regarded across world literature.',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop&q=80',
            ]
        );

        $suVenkatesan = Author::firstOrCreate(
            ['slug' => 'su-venkatesan'],
            [
                'name' => 'Su. Venkatesan',
                'genre' => 'Historical Epics, Tamil Culture',
                'nationality' => 'Indian (Tamil Nadu)',
                'bio' => 'Sahitya Akademi award-winning Tamil writer and historian, celebrated for his magnum opus novels Kaval Kottam and Veerayuga Nayagan Velpari.',
                'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&auto=format&fit=crop&q=80',
            ]
        );

        // Fetch categories
        $novels = Category::where('slug', 'novels')->first();
        $school = Category::where('slug', 'school-books')->first();
        $college = Category::where('slug', 'college-books')->first();
        $nonFiction = Category::where('slug', 'non-fiction')->first();
        $fiction = Category::where('slug', 'fiction')->first();
        $stories = Category::where('slug', 'story-books')->first();
        $edu = Category::where('slug', 'educational-books')->first();

        // 2. Add Tamil Nadu Books
        $tamilNaduBooks = [
            [
                'title' => 'Ponniyin Selvan (Complete 5 Volumes)',
                'author' => 'Kalki Krishnamurthy',
                'author_id' => $kalki->id,
                'category_id' => $novels ? $novels->id : null,
                'category_name' => 'Novels',
                'price' => 599.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1476275466078-4007374efbbe?w=500&auto=format&fit=crop&q=80',
                'description' => 'The timeless historical masterpiece of Tamil literature. Chronicles the intrigue, political romance, and epic naval battles during the early reign of Raja Raja Chola I. Complete box set edition in crisp readable condition.',
                'isbn' => '978-81-8993-605-1',
                'language' => 'Tamil & English',
                'publisher' => 'Vanathi Pathippagam Chennai',
                'pages' => 1240,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 5.0,
            ],
            [
                'title' => 'Thirukkural with Tamil & English Explanation',
                'author' => 'Thiruvalluvar',
                'author_id' => $thiruvalluvar->id,
                'category_id' => $edu ? $edu->id : null,
                'category_name' => 'Educational Books',
                'price' => 240.00,
                'condition' => 'Brand New',
                'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop&q=80',
                'description' => 'The universal Tamil ethical scripture containing all 1,330 couplets across Aram (Virtue), Porul (Governance & Wealth), and Inbam (Love) with clear word-by-word meaning and English translation.',
                'isbn' => '978-81-7440-109-0',
                'language' => 'Tamil & English',
                'publisher' => 'Manivasagar Pathippagam',
                'pages' => 480,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.9,
            ],
            [
                'title' => 'Samacheer Kalvi Class 10 Science & Math Guide',
                'author' => 'TN Textbook Corporation',
                'author_id' => null,
                'category_id' => $school ? $school->id : null,
                'category_name' => 'School Books',
                'price' => 140.00,
                'condition' => 'Good',
                'image' => 'https://images.unsplash.com/photo-1634128221889-82ed6efebfc3?w=500&auto=format&fit=crop&q=80',
                'description' => 'Official Tamil Nadu State Board Class 10 textbook covering Physics, Chemistry, Biology, and Mathematics according to the latest Samacheer Kalvi curriculum. Clean copy with no missing pages.',
                'isbn' => '978-81-2340-982-1',
                'language' => 'English & Tamil',
                'publisher' => 'Tamil Nadu Textbook Corporation, Chennai',
                'pages' => 310,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.7,
            ],
            [
                'title' => 'Engineering Mathematics (Anna University Regulation)',
                'author' => 'Dr. T. Veerarajan',
                'author_id' => null,
                'category_id' => $college ? $college->id : null,
                'category_name' => 'College Books',
                'price' => 420.00,
                'condition' => 'Very Good',
                'image' => 'https://images.unsplash.com/photo-1532012164546-f432f2e3777a?w=500&auto=format&fit=crop&q=80',
                'description' => 'The standard textbook prescribed across Anna University engineering colleges in Tamil Nadu. Detailed coverage of matrices, differential calculus, multiple integrals, and Laplace transforms with solved university question papers.',
                'isbn' => '978-93-5316-248-1',
                'language' => 'English',
                'publisher' => 'McGraw Hill India',
                'pages' => 740,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.8,
            ],
            [
                'title' => 'Akkinich Chiragukal (Wings of Fire Tamil Edition)',
                'author' => 'Dr. A.P.J. Abdul Kalam',
                'author_id' => null,
                'category_id' => $nonFiction ? $nonFiction->id : null,
                'category_name' => 'Non-Fiction',
                'price' => 195.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=500&auto=format&fit=crop&q=80',
                'description' => 'Heartwarming Tamil translation of Dr. APJ Abdul Kalam\'s inspiring autobiography, chronicling his youth in Rameswaram, education in Trichy and Madras, and leadership of India\'s satellite and missile programs.',
                'isbn' => '978-81-8493-210-4',
                'language' => 'Tamil',
                'publisher' => 'Kannadhasan Pathippagam Chennai',
                'pages' => 220,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 5.0,
            ],
            [
                'title' => 'Sivagamiyin Sabatham (சிவகாமியின் சபதம்)',
                'author' => 'Kalki Krishnamurthy',
                'author_id' => $kalki->id,
                'category_id' => $fiction ? $fiction->id : null,
                'category_name' => 'Fiction',
                'price' => 320.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=500&auto=format&fit=crop&q=80',
                'description' => 'Legendary historical drama set in the ancient 7th century Pallava capital of Kanchipuram, recounting the passion of court dancer Sivagami, Prince Mamallan, and the epic siege of Vatapi.',
                'isbn' => '978-81-8993-602-0',
                'language' => 'Tamil',
                'publisher' => 'Vanathi Pathippagam',
                'pages' => 580,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => false,
                'rating' => 4.9,
            ],
            [
                'title' => 'Veerayuga Nayagan Velpari (வேள்பாரி)',
                'author' => 'Su. Venkatesan',
                'author_id' => $suVenkatesan->id,
                'category_id' => $novels ? $novels->id : null,
                'category_name' => 'Novels',
                'price' => 480.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&auto=format&fit=crop&q=80',
                'description' => 'The celebrated contemporary Tamil epic of King Vel Pari, protector of the Parambu hills and indigenous wildlife, who resisted the combined might of the Three Crowned Kings of ancient Tamilakam.',
                'isbn' => '978-93-8884-219-4',
                'language' => 'Tamil',
                'publisher' => 'Vikatan Publications',
                'pages' => 640,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.9,
            ],
            [
                'title' => 'Tenali Raman & Tamil Folktales for Children',
                'author' => 'Traditional Tamil Lore',
                'author_id' => null,
                'category_id' => $stories ? $stories->id : null,
                'category_name' => 'Story Books',
                'price' => 120.00,
                'condition' => 'Brand New',
                'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&auto=format&fit=crop&q=80',
                'description' => 'Charming collection of 25 wit and wisdom tales of Tenali Raman, Mariyadhai Raman, and classic village fables of Tamil Nadu with vibrant illustrations.',
                'isbn' => '978-81-7950-432-8',
                'language' => 'Tamil & English',
                'publisher' => 'Giri Trading Publications Chennai',
                'pages' => 140,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => false,
                'rating' => 4.8,
            ],
        ];

        foreach ($tamilNaduBooks as $b) {
            Book::updateOrCreate(
                ['title' => $b['title']],
                $b
            );
        }
    }
}
