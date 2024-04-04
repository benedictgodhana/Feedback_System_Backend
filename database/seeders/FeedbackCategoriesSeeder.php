<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FeedbackCategory;

class FeedbackCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'General', 'description' => 'General feedback'],
            ['name' => 'Technical', 'description' => 'Technical feedback'],
            ['name' => 'Customer Service', 'description' => 'Feedback related to customer service'],
            // Add more categories as needed
        ];

        // Insert categories into the database
        foreach ($categories as $category) {
            FeedbackCategory::create($category);
        }

    }
}
