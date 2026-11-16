<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\BlogPost;
use App\Models\Book;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookExchangeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories (All 7 required categories)
        $categoriesData = [
            [
                'name' => 'School Books',
                'slug' => 'school-books',
                'icon' => 'fa-graduation-cap',
                'description' => 'Textbooks, workbooks, reference guides for CBSE, ICSE, and State Board classes 1 through 12.',
            ],
            [
                'name' => 'College Books',
                'slug' => 'college-books',
                'icon' => 'fa-building-columns',
                'description' => 'Higher education textbooks for Engineering, Medicine, Commerce, Science, Arts, and Law.',
            ],
            [
                'name' => 'Story Books',
                'slug' => 'story-books',
                'icon' => 'fa-wand-magic-sparkles',
                'description' => 'Fables, Panchatantra, bedtime stories, fairy tales, and illustrated adventures for young readers.',
            ],
            [
                'name' => 'Novels',
                'slug' => 'novels',
                'icon' => 'fa-book-bookmark',
                'description' => 'Timeless classics, historical sagas, contemporary drama, and acclaimed bestsellers from around the globe.',
            ],
            [
                'name' => 'Fiction',
                'slug' => 'fiction',
                'icon' => 'fa-dragon',
                'description' => 'Science fiction, mystery thrillers, high fantasy, mythological retellings, and suspense novels.',
            ],
            [
                'name' => 'Non-Fiction',
                'slug' => 'non-fiction',
                'icon' => 'fa-lightbulb',
                'description' => 'Inspirational biographies, personal growth, psychology, business philosophy, and history.',
            ],
            [
                'name' => 'Educational Books',
                'slug' => 'educational-books',
                'icon' => 'fa-brain',
                'description' => 'Competitive exam study material for UPSC, JEE, NEET, GATE, Bank PO, and programming languages.',
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $catData) {
            $categories[$catData['name']] = Category::firstOrCreate(
                ['slug' => $catData['slug']],
                $catData
            );
        }

        // 2. Authors
        $authorsData = [
            [
                'name' => 'Dr. A.P.J. Abdul Kalam',
                'slug' => 'dr-apj-abdul-kalam',
                'genre' => 'Inspirational, Non-Fiction, Science',
                'nationality' => 'Indian',
                'bio' => 'Beloved scientist and 11th President of India, known as the Missile Man of India. Author of inspiring books like Wings of Fire, Ignited Minds, and India 2020.',
                'photo' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'R.K. Narayan',
                'slug' => 'rk-narayan',
                'genre' => 'Fiction, Indian Classics',
                'nationality' => 'Indian',
                'bio' => 'One of the pioneers of early Indian literature in English, creator of the fictional town of Malgudi, Swami and Friends, and The Guide.',
                'photo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Ruskin Bond',
                'slug' => 'ruskin-bond',
                'genre' => 'Children\'s Literature, Story Books, Nature',
                'nationality' => 'Indian',
                'bio' => 'Acclaimed author residing in Landour, Mussoorie. Celebrated for evocative stories of nature, the Himalayas, and heartwarming childhood tales like The Blue Umbrella.',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Sudha Murty',
                'slug' => 'sudha-murty',
                'genre' => 'Stories, Value Education, Non-Fiction',
                'nationality' => 'Indian',
                'bio' => 'Renowned educator, author, and philanthropist. Recipient of Padma Bhushan, famous for heartwarming morals in Grandma\'s Bag of Stories and Three Thousand Stitches.',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Rabindranath Tagore',
                'slug' => 'rabindranath-tagore',
                'genre' => 'Literature, Poetry, Philosophy',
                'nationality' => 'Indian',
                'bio' => 'Nobel Laureate in Literature (1913), composer of national anthems, and author of Gitanjali, The Post Office, and Kabuliwala.',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Chetan Bhagat',
                'slug' => 'chetan-bhagat',
                'genre' => 'Contemporary Novels, Youth Fiction',
                'nationality' => 'Indian',
                'bio' => 'Popular Indian novelist and columnist, author of Five Point Someone, 2 States, and Revolution 2020.',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&auto=format&fit=crop&q=80',
            ],
        ];

        $authors = [];
        foreach ($authorsData as $authData) {
            $authors[$authData['name']] = Author::firstOrCreate(
                ['slug' => $authData['slug']],
                $authData
            );
        }

        // 3. Update existing 8 books with valid categories and details
        $existingBooks = Book::take(8)->get();
        $sampleBookData = [
            1 => [
                'title' => 'NCERT Mathematics Class 10',
                'author' => 'NCERT Board of Editors',
                'category' => 'School Books',
                'price' => 180.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1634128221889-82ed6efebfc3?w=500&auto=format&fit=crop&q=80',
                'description' => 'Complete NCERT Class 10 Mathematics textbook covering quadratic equations, trigonometry, geometry and statistics. Clean pages with no markings.',
                'isbn' => '978-81-7450-634-4',
                'language' => 'English',
                'publisher' => 'NCERT New Delhi',
                'pages' => 320,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.8,
            ],
            2 => [
                'title' => 'Higher Engineering Mathematics',
                'author' => 'Dr. B.S. Grewal',
                'category' => 'College Books',
                'price' => 450.00,
                'condition' => 'Good',
                'image' => 'https://images.unsplash.com/photo-1532012164546-f432f2e3777a?w=500&auto=format&fit=crop&q=80',
                'description' => 'Standard textbook for all branches of engineering including calculus, differential equations, linear algebra and complex analysis. 44th Edition.',
                'isbn' => '978-81-7409-195-5',
                'language' => 'English',
                'publisher' => 'Khanna Publishers',
                'pages' => 1340,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.9,
            ],
            3 => [
                'title' => 'Grandma\'s Bag of Stories',
                'author' => 'Sudha Murty',
                'category' => 'Story Books',
                'price' => 199.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&auto=format&fit=crop&q=80',
                'description' => 'Charming collection of 21 traditional Indian tales full of wonder, wit, kings, magical creatures and valuable life lessons told by grandparents.',
                'isbn' => '978-01-4333-362-3',
                'language' => 'English',
                'publisher' => 'Puffin Books',
                'pages' => 176,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.9,
            ],
            4 => [
                'title' => 'The Guide',
                'author' => 'R.K. Narayan',
                'category' => 'Novels',
                'price' => 240.00,
                'condition' => 'Very Good',
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=500&auto=format&fit=crop&q=80',
                'description' => 'Winner of the Sahitya Akademi Award, telling the unforgettable journey of Raju the tour guide who turns into a spiritual guru in Malgudi.',
                'isbn' => '978-81-8598-601-2',
                'language' => 'English',
                'publisher' => 'Indian Thought Publications',
                'pages' => 220,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.7,
            ],
            5 => [
                'title' => 'Wings of Fire: An Autobiography',
                'author' => 'Dr. A.P.J. Abdul Kalam',
                'category' => 'Non-Fiction',
                'price' => 299.00,
                'condition' => 'Brand New',
                'image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?w=500&auto=format&fit=crop&q=80',
                'description' => 'The inspiring life journey of Dr. APJ Abdul Kalam, from his humble origins in Rameswaram to leading India\'s space and missile development programs.',
                'isbn' => '978-81-7371-146-6',
                'language' => 'English',
                'publisher' => 'Universities Press',
                'pages' => 180,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 5.0,
            ],
            6 => [
                'title' => 'The Immortals of Meluha',
                'author' => 'Amish Tripathi',
                'category' => 'Fiction',
                'price' => 320.00,
                'condition' => 'Good',
                'image' => 'https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=500&auto=format&fit=crop&q=80',
                'description' => 'The captivating first book of the Shiva Trilogy. Fast-paced mythological fiction depicting the legend of Shiva as a Tibetan immigrant turned savior.',
                'isbn' => '978-93-8065-874-2',
                'language' => 'English',
                'publisher' => 'Westland',
                'pages' => 412,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => false,
                'rating' => 4.6,
            ],
            7 => [
                'title' => 'Indian Polity for Civil Services',
                'author' => 'M. Laxmikanth',
                'category' => 'Educational Books',
                'price' => 590.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=500&auto=format&fit=crop&q=80',
                'description' => 'The undisputed bible for UPSC and State PSC exams. Detailed coverage of the Indian Constitution, Parliament, Judiciary, and Governance. 7th Edition.',
                'isbn' => '978-93-5532-386-8',
                'language' => 'English',
                'publisher' => 'McGraw Hill',
                'pages' => 890,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.9,
            ],
            8 => [
                'title' => 'The Blue Umbrella',
                'author' => 'Ruskin Bond',
                'category' => 'Story Books',
                'price' => 140.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1495640388908-05fa85288e61?w=500&auto=format&fit=crop&q=80',
                'description' => 'Heartwarming novella set in a Garhwal village revolving around a little girl Binya and her prized bright blue silk umbrella.',
                'isbn' => '978-81-7167-340-7',
                'language' => 'English',
                'publisher' => 'Rupa Publications',
                'pages' => 90,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => false,
                'rating' => 4.8,
            ],
        ];

        foreach ($existingBooks as $index => $book) {
            $num = $index + 1;
            if (isset($sampleBookData[$num])) {
                $data = $sampleBookData[$num];
                $cat = $categories[$data['category']] ?? null;
                $authorModel = $authors[$data['author']] ?? null;

                $book->update([
                    'title' => $data['title'],
                    'author' => $data['author'],
                    'category_id' => $cat ? $cat->id : null,
                    'author_id' => $authorModel ? $authorModel->id : null,
                    'category_name' => $data['category'],
                    'price' => $data['price'],
                    'image' => $data['image'],
                    'description' => $data['description'],
                    'condition' => $data['condition'],
                    'isbn' => $data['isbn'],
                    'language' => $data['language'],
                    'publisher' => $data['publisher'],
                    'pages' => $data['pages'],
                    'is_exchangeable' => $data['is_exchangeable'],
                    'exchange_type' => $data['exchange_type'],
                    'featured' => $data['featured'],
                    'rating' => $data['rating'],
                ]);
            }
        }

        // 4. Additional Books across all categories to guarantee rich variety
        $additionalBooks = [
            // School Books
            [
                'title' => 'Concepts of Physics (Vol 1 & 2)',
                'author' => 'Dr. H.C. Verma',
                'category' => 'School Books',
                'price' => 420.00,
                'condition' => 'Very Good',
                'image' => 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?w=500&auto=format&fit=crop&q=80',
                'description' => 'Classic textbook for Class 11-12 physics and competitive exams. Clear intuitive explanations with solved numerical problems.',
                'isbn' => '978-81-7709-187-8',
                'language' => 'English',
                'publisher' => 'Bharati Bhawan',
                'pages' => 462,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.9,
            ],
            // College Books
            [
                'title' => 'Operating System Concepts',
                'author' => 'Silberschatz, Galvin & Gagne',
                'category' => 'College Books',
                'price' => 520.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=500&auto=format&fit=crop&q=80',
                'description' => 'The celebrated "Dinosaur Book" covering processes, threads, memory management, file systems, and distributed operating systems.',
                'isbn' => '978-11-1980-036-1',
                'language' => 'English',
                'publisher' => 'Wiley India',
                'pages' => 976,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => false,
                'rating' => 4.8,
            ],
            // Novels
            [
                'title' => 'Malgudi Days',
                'author' => 'R.K. Narayan',
                'category' => 'Novels',
                'price' => 220.00,
                'condition' => 'Brand New',
                'image' => 'https://images.unsplash.com/photo-1476275466078-4007374efbbe?w=500&auto=format&fit=crop&q=80',
                'description' => 'Collection of 32 heartwarming short stories portraying the humor, warmth, and daily dilemmas of life in the southern fictional town of Malgudi.',
                'isbn' => '978-81-8598-617-3',
                'language' => 'English',
                'publisher' => 'Indian Thought Publications',
                'pages' => 256,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.9,
            ],
            // Fiction
            [
                'title' => 'Midnight\'s Children',
                'author' => 'Salman Rushdie',
                'category' => 'Fiction',
                'price' => 380.00,
                'condition' => 'Good',
                'image' => 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=500&auto=format&fit=crop&q=80',
                'description' => 'Booker Prize winner. Magical realism tale following Saleem Sinai, born at the stroke of midnight on India\'s independence day.',
                'isbn' => '978-00-9957-851-2',
                'language' => 'English',
                'publisher' => 'Vintage Books',
                'pages' => 656,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => false,
                'rating' => 4.6,
            ],
            // Non-Fiction
            [
                'title' => 'Ignited Minds: Unleashing the Power Within India',
                'author' => 'Dr. A.P.J. Abdul Kalam',
                'category' => 'Non-Fiction',
                'price' => 210.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1509021436665-8f07dbf5bf1d?w=500&auto=format&fit=crop&q=80',
                'description' => 'Inspiring call to youth urging every Indian student to dream big, develop scientific temper, and contribute towards national development.',
                'isbn' => '978-01-4342-412-3',
                'language' => 'English',
                'publisher' => 'Penguin India',
                'pages' => 205,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.9,
            ],
            // Educational Books
            [
                'title' => 'Data Structures and Algorithms Made Easy',
                'author' => 'Narasimha Karumanchi',
                'category' => 'Educational Books',
                'price' => 490.00,
                'condition' => 'Like New',
                'image' => 'https://images.unsplash.com/photo-1515879218367-8466d910aaa4?w=500&auto=format&fit=crop&q=80',
                'description' => 'Comprehensive handbook for coding interviews, campus placements, and GATE computer science exam preparation.',
                'isbn' => '978-81-9324-527-9',
                'language' => 'English',
                'publisher' => 'CareerMonk Publications',
                'pages' => 448,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => true,
                'rating' => 4.9,
            ],
            // Story Books
            [
                'title' => 'Panchatantra: Complete Illustrated Tales',
                'author' => 'Pandit Vishnu Sharma',
                'category' => 'Story Books',
                'price' => 175.00,
                'condition' => 'Brand New',
                'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&auto=format&fit=crop&q=80',
                'description' => 'Ancient Indian animal fables demonstrating political wisdom, friendship, loyalty, and practical intelligence in everyday dilemmas.',
                'isbn' => '978-81-7167-065-9',
                'language' => 'English',
                'publisher' => 'Rupa Publications',
                'pages' => 280,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => false,
                'rating' => 4.7,
            ],
            // Novels
            [
                'title' => '2 States: The Story of My Marriage',
                'author' => 'Chetan Bhagat',
                'category' => 'Novels',
                'price' => 195.00,
                'condition' => 'Very Good',
                'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=500&auto=format&fit=crop&q=80',
                'description' => 'A humorous and heartfelt tale of Krish from Delhi and Ananya from Chennai falling in love at IIM Ahmedabad and convincing their families.',
                'isbn' => '978-81-2911-530-0',
                'language' => 'English',
                'publisher' => 'Rupa Publications',
                'pages' => 269,
                'is_exchangeable' => true,
                'exchange_type' => 'Buy / Exchange',
                'featured' => false,
                'rating' => 4.5,
            ]
        ];

        foreach ($additionalBooks as $bookItem) {
            $cat = $categories[$bookItem['category']] ?? null;
            $authorModel = $authors[$bookItem['author']] ?? null;

            Book::firstOrCreate(
                ['title' => $bookItem['title'], 'author' => $bookItem['author']],
                [
                    'category_id' => $cat ? $cat->id : null,
                    'author_id' => $authorModel ? $authorModel->id : null,
                    'category_name' => $bookItem['category'],
                    'price' => $bookItem['price'],
                    'image' => $bookItem['image'],
                    'description' => $bookItem['description'],
                    'condition' => $bookItem['condition'],
                    'isbn' => $bookItem['isbn'],
                    'language' => $bookItem['language'],
                    'publisher' => $bookItem['publisher'],
                    'pages' => $bookItem['pages'],
                    'is_exchangeable' => $bookItem['is_exchangeable'],
                    'exchange_type' => $bookItem['exchange_type'],
                    'featured' => $bookItem['featured'],
                    'rating' => $bookItem['rating'],
                ]
            );
        }

        // 5. Events
        $eventsData = [
            [
                'title' => 'Chennai Community Book Swap Meet 2026',
                'slug' => 'chennai-community-book-swap-meet-2026',
                'event_date' => now()->addDays(7)->format('Y-m-d'),
                'event_time' => '10:00 AM - 2:00 PM',
                'location' => 'Semmozhi Poonga Outdoor Amphitheater, Cathedral Road, Chennai',
                'event_type' => 'Book Exchange Meet',
                'description' => 'Bring any 3 to 10 gently read books from home and exchange them token-for-token with fellow avid bibliophiles! All categories welcome: School & College textbooks, novels, comics, and non-fiction. Complimentary filter coffee and bookmarks for all attendees.',
                'speaker' => 'Moderated by Chennai Readers Club',
                'image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=600&auto=format&fit=crop&q=80',
                'entry_fee' => 'Free Entry (RSVP Required)',
                'max_attendees' => 120,
                'attendees_count' => 64,
            ],
            [
                'title' => 'College Textbook & Semester Notes Exchange Drive',
                'slug' => 'college-textbook-semester-notes-exchange-drive',
                'event_date' => now()->addDays(14)->format('Y-m-d'),
                'event_time' => '11:00 AM - 4:00 PM',
                'location' => 'University Student Center Hall B, Guindy, Chennai',
                'event_type' => 'Academic Book Drive',
                'description' => 'Senior engineering, medical, commerce, and science students donate and exchange previous semester textbooks, lab manuals, and handwritten notes with incoming juniors. Save thousands on curriculum expenses while fostering campus solidarity.',
                'speaker' => 'Dr. K. Senthil, Dean of Academic Affairs',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=600&auto=format&fit=crop&q=80',
                'entry_fee' => 'Free Entry',
                'max_attendees' => 200,
                'attendees_count' => 142,
            ],
            [
                'title' => 'Mastering Competitive Exams: UPSC, JEE & GATE Book Circle',
                'slug' => 'mastering-competitive-exams-upsc-jee-gate-book-circle',
                'event_date' => now()->addDays(21)->format('Y-m-d'),
                'event_time' => '4:00 PM - 6:30 PM',
                'location' => 'Online Live Interactive Webinar & Book Sharing Forum',
                'event_type' => 'Aspirants Workshop',
                'description' => 'A dedicated forum for government and competitive exam aspirants to trade standard reference books, mock test series, and strategy notes. Featuring Q&A with top rankers.',
                'speaker' => 'Priya Raman, IAS 2024 Batch',
                'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&auto=format&fit=crop&q=80',
                'entry_fee' => 'Free Online Access',
                'max_attendees' => 300,
                'attendees_count' => 218,
            ],
            [
                'title' => 'Young Readers & Storytelling Weekend Festival',
                'slug' => 'young-readers-storytelling-weekend-festival',
                'event_date' => now()->addDays(28)->format('Y-m-d'),
                'event_time' => '3:30 PM - 6:00 PM',
                'location' => 'Children\'s Pavilion, Anna Centenary Library, Kotturpuram',
                'event_type' => 'Kids Story Hour & Exchange',
                'description' => 'An afternoon of live dramatized storytelling from Panchatantra and Ruskin Bond, followed by a children\'s book swap where kids can exchange their illustrated stories and comics.',
                'speaker' => 'Ananya Sharma, Storyteller & Author',
                'image' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&auto=format&fit=crop&q=80',
                'entry_fee' => 'Free Entry',
                'max_attendees' => 80,
                'attendees_count' => 52,
            ],
        ];

        foreach ($eventsData as $eventItem) {
            Event::firstOrCreate(['slug' => $eventItem['slug']], $eventItem);
        }

        // 6. Blog Posts
        $postsData = [
            [
                'title' => 'Why Exchanging Pre-Loved Books is the Smartest Choice for Students in India',
                'slug' => 'why-exchanging-pre-loved-books-is-smart-for-students',
                'author_name' => 'Kavitha Sundaram',
                'category' => 'Sustainable Reading',
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=700&auto=format&fit=crop&q=80',
                'read_time' => '4 min read',
                'excerpt' => 'College textbooks often cost thousands every semester only to gather dust. Discover how student book exchanges save finances and reduce paper waste across Indian universities.',
                'content' => 'Every academic year, millions of Indian college and school students invest thousands of rupees buying fresh textbooks, only for those very volumes to sit untouched on high shelves once final semester examinations conclude.

A community book exchange fundamentally alters this equation. By facilitating peer-to-peer exchanges and low-cost pre-loved book sales in Indian Rupees (₹), platforms like BooksApp empower students to acquire vital reference materials at a fraction of their cover price.

Furthermore, book recycling has monumental environmental benefits. Each exchanged book preserves precious forest resources, saves hundreds of liters of water used in industrial paper manufacturing, and avoids carbon emissions associated with publishing and logistics. Join the movement today by listing your read books for swap!',
                'published_at' => now()->subDays(3)->format('Y-m-d'),
            ],
            [
                'title' => 'Top 10 Indian Classic Novels Every Bibliophile Must Read',
                'slug' => 'top-10-indian-classic-novels-must-read',
                'author_name' => 'Arun Kumar',
                'category' => 'Book Recommendations',
                'image' => 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?w=700&auto=format&fit=crop&q=80',
                'read_time' => '6 min read',
                'excerpt' => 'From the serene streets of R.K. Narayan’s Malgudi to Tagore’s philosophical masterpieces, explore the timeless literary treasures that define Indian storytelling.',
                'content' => 'Indian literature possesses an extraordinary wealth of narrative depth, regional flavors, and cultural richness. When embarking on an exploration of classic Indian fiction, these landmark books deserve pride of place on your reading table:

1. **The Guide by R.K. Narayan:** A poignant, witty exploration of human transformation, deceit, and unexpected saintliness set in the immortal universe of Malgudi.
2. **Gitanjali by Rabindranath Tagore:** Lyrical, spiritual verses that earned India its first Nobel Prize in 1913.
3. **Train to Pakistan by Khushwant Singh:** A harrowing, humane narrative of love and resilience set against the tragic backdrop of the 1947 Partition.
4. **The God of Small Things by Arundhati Roy:** Booker Prize-winning prose exploring family secrets, caste dynamics, and forbidden love in Kerala.
5. **Clear Light of Day by Anita Desai:** A masterclass in domestic nuance and post-independence Indian family life.

All these masterpieces are frequently available for exchange in our community catalog right now.',
                'published_at' => now()->subDays(8)->format('Y-m-d'),
            ],
            [
                'title' => 'How to Care for Second-Hand Books and Maintain Their Quality',
                'slug' => 'how-to-care-for-second-hand-books',
                'author_name' => 'Editorial Desk',
                'category' => 'Book Care & Tips',
                'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=700&auto=format&fit=crop&q=80',
                'read_time' => '5 min read',
                'excerpt' => 'Keep your collection in mint condition! Simple DIY preservation techniques to protect book bindings, prevent yellowing, and shield pages from humidity.',
                'content' => 'Books have an almost magical lifespan when cared for with affection. When you exchange or purchase pre-loved books, a few mindful habits ensure they remain pristine for decades:

- **Shield Against Direct Sunlight:** Ultraviolet radiation breaks down paper fibers and bleaches jacket inks, causing noticeable yellowing. Store books away from direct window rays.
- **Maintain Optimal Airflow in Humid Climates:** Especially during Indian monsoon seasons, ensure bookshelves are slightly off the wall to prevent dampness and mildew.
- **Use Acid-Free Bookmarks:** Avoid folding page corners (dog-earing) or using metal paperclips that leave rust impressions.
- **Gentle Erasing:** For pencil notes left by previous student owners, use a soft kneaded art eraser gently in single directional strokes.

Caring for your books preserves their exchange value and ensures the next reader enjoys them just as much as you did.',
                'published_at' => now()->subDays(15)->format('Y-m-d'),
            ],
        ];

        foreach ($postsData as $postItem) {
            BlogPost::firstOrCreate(['slug' => $postItem['slug']], $postItem);
        }
    }
}
