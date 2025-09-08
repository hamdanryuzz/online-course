<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManageExamController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Admin lihat semua course + jumlah exam
            $courses = Course::withCount('exams')->get();
        } else if ($user->role === 'teacher') {
            // Teacher lihat hanya course miliknya
            $courses = Course::withCount('exams')
                ->where('user_id', $user->id)
                ->get();
        } else {
            $courses = collect(); // selain admin/teacher kosong
        }

        return view('manage-exam.index', compact('courses'));
    }


    public function show($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        // Cek jika teacher, pastikan course miliknya
        if ($user->role === 'teacher' && $course->user_id !== $user->id) {
            abort(403, 'Unauthorized access to this course.');
        }

        $exams = Exam::where('course_id', $courseId)->get();

        return view('manage-exam.show', compact('course', 'exams'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'question'  => 'required|string',
            'options'   => 'required|array|min:2',
            'answer'    => 'required|string',
        ]);

        Exam::create([
            'course_id' => $request->course_id,
            'question'  => $request->question,
            'options'   => $request->options,
            'answer'    => $request->answer,
        ]);

        return back()->with('success', 'Question added.');
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'question' => 'required|string',
            'options'  => 'required|array|min:2',
            'answer'   => 'required|string',
        ]);

        $exam->update($request->all());

        return back()->with('success', 'Question updated.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return back()->with('success', 'Question deleted.');
    }
}