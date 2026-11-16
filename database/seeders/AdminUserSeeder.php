<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Dedicated Admin User
        User::updateOrCreate(
            ['email' => 'admin@booksapp.com'],
            [
                'name' => 'BooksApp Administrator',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        // 2. Also grant admin privileges to existing user accounts
        User::whereIn('email', [
            'indhukarthi22005@gmail.com',
            'indhu22005@gmail.com',
            'ishuamuu@gmail.com',
        ])->update(['is_admin' => true]);
    }
}
