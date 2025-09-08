<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exams = [
            [
                'course_id' => 1,
                'question' => 'Apa kepanjangan dari HTML?',
                'options' => json_encode(['Hyper Text Markup Language', 'High Text Machine Language', 'Hyperlink Markup Language', 'Home Tool Markup Language']),
                'answer' => 'Hyper Text Markup Language',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 1,
                'question' => 'Apa fungsi CSS dalam website?',
                'options' => json_encode(['Membuat website interaktif', 'Menentukan struktur website', 'Memberi style tampilan website', 'Menambahkan database']),
                'answer' => 'Memberi style tampilan website',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 1,
                'question' => 'Bahasa pemrograman yang digunakan untuk backend biasanya adalah?',
                'options' => json_encode(['HTML', 'CSS', 'PHP', 'Photoshop']),
                'answer' => 'PHP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 1,
                'question' => 'Framework Laravel menggunakan bahasa?',
                'options' => json_encode(['JavaScript', 'PHP', 'Python', 'Ruby']),
                'answer' => 'PHP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 1,
                'question' => 'Tag HTML untuk membuat link adalah?',
                'options' => json_encode(['<link>', '<a>', '<href>', '<url>']),
                'answer' => '<a>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('exams')->insert($exams);
    }
}
