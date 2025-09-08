<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseUser;

class CourseUserController extends Controller
{
    public function assign(Request $request, Course $course)
    {
        $request->validate([
            'users' => 'array',
            'users.*' => 'exists:users,id'
        ]);

        // Hapus semua assignment lama
        CourseUser::where('course_id', $course->id)->delete();

        // Simpan assignment baru
        if ($request->has('users')) {
            foreach ($request->users as $userId) {
                CourseUser::create([
                    'course_id' => $course->id,
                    'user_id' => $userId,
                ]);
            }
        }

        return redirect()->route('manage-course.index')->with('success', 'Users assigned successfully.');
    }
}
