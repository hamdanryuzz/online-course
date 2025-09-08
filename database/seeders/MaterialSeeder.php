<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\Course;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();

        // Use actual working YouTube video IDs
        $videos = [
            'https://www.youtube.com/embed/8mAITcNt710', // Python tutorial
            'https://www.youtube.com/embed/UB1O30fR-EE', // HTML tutorial
            'https://www.youtube.com/embed/W6NZfCO5SIk', // JavaScript tutorial
            'https://www.youtube.com/embed/BWXggB-T1jQ', // CSS tutorial
            'https://www.youtube.com/embed/8jLOx1hD3_o', // PHP tutorial
        ];

        foreach ($courses as $course) {
            for ($i = 1; $i <= 3; $i++) {
                Material::create([
                    'course_id' => $course->id,
                    'title' => "Lesson $i: {$this->getLessonTitle($course->name, $i)}",
                    'file' => $videos[array_rand($videos)],
                    'description' => "This is lesson $i of {$course->name}. Learn the fundamentals and build your skills.",
                ]);
            }
        }
    }

    private function getLessonTitle($courseName, $lessonNumber): string
    {
        $titles = [
            'Introduction to Basics',
            'Advanced Concepts',
            'Practical Applications',
            'Project Building',
            'Best Practices'
        ];
        
        return $titles[($lessonNumber - 1) % count($titles)];
    }
}