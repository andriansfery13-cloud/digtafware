<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);
        $isEnterprise = fake()->boolean(10); // 10% chance of being enterprise

        return [
            'title' => ucwords($title),
            'slug' => Str::slug($title),
            'category_id' => Category::factory(),
            'description' => fake()->paragraphs(3, true),
            'features' => "- Feature 1\n- Feature 2\n- Feature 3",
            'requirements' => "PHP 8.2\nMySQL 8.0",
            'price' => $isEnterprise ? null : fake()->randomFloat(2, 10, 500),
            'is_enterprise' => $isEnterprise,
            'demo_url' => fake()->url(),
            'version' => '1.0.0',
            'download_count' => fake()->numberBetween(0, 1000),
            'status' => 'published',
        ];
    }
}
