<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;


class ExamController extends Controller
{
    
    public function show(Course $course)
    {
        $user = Auth::user();

        // Cek apakah user sudah menyelesaikan semua materials
        $completedIds = $user->completedMaterials()->pluck('material_id')->toArray();

        if ($course->materials->pluck('id')->diff($completedIds)->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Complete all materials first!'
            ], 403);
        }

        $exams = $course->exams()->get();

        return response()->json([
            'status' => 'success',
            'course' => $course->only('id', 'name'),
            'exams' => $exams
        ]);
    }

    public function submit(Request $request, Course $course)
    {
        $user = Auth::user();

        $request->validate([
            'answers' => 'required|array'
        ]);

        $answers = $request->input('answers', []);
        $exams = $course->exams;
        $score = 0;

        foreach ($exams as $exam) {
            if (isset($answers[$exam->id]) && $answers[$exam->id] === $exam->answer) {
                $score++;
            }
        }

        $totalScore = $exams->count() > 0 ? ($score / $exams->count()) * 100 : 0;

        $result = ExamResult::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'score' => $totalScore,
            'answers' => $answers
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Exam submitted!',
            'score' => $score,
            'total_questions' => $exams->count(),
            'percentage' => $totalScore,
            'result' => $result
        ]);
    }

}
