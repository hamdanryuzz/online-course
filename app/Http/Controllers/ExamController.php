<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ExamResult;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function show(Course $course)
    {
        $user = Auth::user();
        $completedIds = $user->completedMaterials()->pluck('material_id')->toArray();

        if ($course->materials->pluck('id')->diff($completedIds)->count() > 0) {
            return redirect()->route('home')->with('error', 'Complete all materials first!');
        }

        $exams = $course->exams()->get();
        return view('exam.exam', compact('course', 'exams'));
    }

    public function submit(Request $request, Course $course)
    {
        $user = Auth::user();
        $answers = $request->input('answers', []);
        $exams = $course->exams;
        $score = 0;
        foreach ($course->exams as $exam) {
            if (isset($answers[$exam->id]) && $answers[$exam->id] === $exam->answer) {
                $score++;
            }
        }
        $totalScore = ($score / $exams->count()) * 100;
        ExamResult::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'score' => $totalScore,
            'answers' => $answers
        ]);

        return redirect()->route('home')->with('success', "Exam submitted! Your score: $score / " . $course->exams->count());
    }
}
