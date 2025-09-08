<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create([
            'name' => 'Introduction to Programming',
            'description' => 'Learn the basics of programming with Python and build your first projects.',
            'cover' => 'https://picsum.photos/400/250?random=1',
            'user_id' => 2,
            'category_id' => 1,
        ]);

        Course::create([
            'name' => 'Web Development Bootcamp',
            'description' => 'Master HTML, CSS, JavaScript, and create responsive websites.',
            'cover' => 'https://picsum.photos/400/250?random=2',
            'user_id' => 2,
            'category_id' => 2,
        ]);

        Course::create([
            'name' => 'Data Science Essentials',
            'description' => 'Learn data analysis, visualization, and machine learning techniques.',
            'cover' => 'https://picsum.photos/400/250?random=3',
            'user_id' => 2,
            'category_id' => 1,
        ]);

        Course::create([
            'name' => 'UI/UX Design Fundamentals',
            'description' => 'Understand the principles of user interface and user experience design.',
            'cover' => 'https://picsum.photos/400/250?random=4',
            'user_id' => 2,
            'category_id' => 2,
        ]);

        Course::create([
            'name' => 'Advanced JavaScript',
            'description' => 'Deep dive into JavaScript ES6+, async programming, and modern frameworks.',
            'cover' => 'https://picsum.photos/400/250?random=5',
            'user_id' => 2,
            'category_id' => 1,
        ]);
    }
}
