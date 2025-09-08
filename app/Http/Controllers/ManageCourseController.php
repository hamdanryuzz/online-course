<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class ManageCourseController extends Controller
{
    public function index()
    {
        $courses = $this->getCourses();
        return view('manage-course.manage-course', compact('courses'));
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

        return collect(); // jika role lain, kosong
    }



    public function create()
    {
        return view('manage-course.crud');
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

        Course::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'cover' => '/storage/' . $coverPath,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('manage-course.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        return view('manage-course.crud', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            $course->cover = '/storage/' . $coverPath;
        }

        $course->name = $request->name;
        $course->description = $request->description;
        $course->category_id = $request->category_id;
        $course->save();

        return redirect()->route('manage-course.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('manage-course.index')->with('success', 'Course deleted successfully.');
    }


}
