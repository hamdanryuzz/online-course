<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class ManageCourseController extends Controller
{
    public function index()
    {
        $courses = $this->getCourses();
        return response()->json([
            'status' => 'success',
            'courses' => $courses
        ]);
    }

    private function getCourses()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return Course::latest()->get();
        }

        if ($user->role === 'teacher') {
            return Course::where('user_id', $user->id)->latest()->get();
        }

        return collect();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        $coverPath = $request->file('cover')->store('covers', 'public');

        $course = Course::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'cover' => '/storage/' . $coverPath,
            'category_id' => $request->category_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Course created successfully',
            'course' => $course
        ]);
    }

    public function show(Course $course)
    {
        return response()->json([
            'status' => 'success',
            'course' => $course
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            $course->cover = '/storage/' . $coverPath;
        }

        $course->name = $request->name;
        $course->description = $request->description;
        $course->category_id = $request->category_id;
        $course->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Course updated successfully',
            'course' => $course
        ]);
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Course deleted successfully'
        ]);
    }
}
