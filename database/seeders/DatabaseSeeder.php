<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin User
        User::factory()->create([
            'name' => 'Admin DigtafWare',
            'email' => 'admin@digtafware.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Default Test User
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Categories & Products
        $categories = [
            'POS Software',
            'Website Builder',
            'Business Software',
            'Developer Tools',
            'Templates'
        ];

        foreach ($categories as $categoryName) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'description' => "Category for $categoryName"
            ]);

            Product::factory(5)->create([
                'category_id' => $category->id
            ]);
        }
    }
}
