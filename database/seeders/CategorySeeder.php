<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Coding',
                'description' => 'Kategori untuk materi pemrograman dan coding.',
            ],
            [
                'name' => 'Bahasa Inggris',
                'description' => 'Kategori untuk materi Bahasa Inggris.',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
