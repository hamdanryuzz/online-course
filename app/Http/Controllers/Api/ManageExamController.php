<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageExamController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $courses = Course::withCount('exams')->get();
        } elseif ($user->role === 'teacher') {
            $courses = Course::withCount('exams')
                ->where('user_id', $user->id)
                ->get();
        } else {
            $courses = collect();
        }

        return response()->json([
            'status' => 'success',
            'data'   => $courses
        ]);
    }

    public function show($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        if ($user->role === 'teacher' && $course->user_id !== $user->id) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized access to this course'
            ], 403);
        }

        $exams = Exam::where('course_id', $courseId)->get();

        return response()->json([
            'status' => 'success',
            'course' => $course,
            'exams'  => $exams
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'question'  => 'required|string',
            'options'   => 'required|array|min:2',
            'answer'    => 'required|string',
        ]);

        $exam = Exam::create([
            'course_id' => $request->course_id,
            'question'  => $request->question,
            'options'   => $request->options,
            'answer'    => $request->answer,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Question added',
            'data'    => $exam
        ], 201);
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'question' => 'required|string',
            'options'  => 'required|array|min:2',
            'answer'   => 'required|string',
        ]);

        $exam->update($request->all());

        return response()->json([
            'status'  => 'success',
            'message' => 'Question updated',
            'data'    => $exam
        ]);
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Question deleted'
        ]);
    }
}
