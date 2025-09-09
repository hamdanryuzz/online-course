<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        return response()->json([
            'status' => 'success',
            'message' => 'Users assigned successfully',
            'assigned_users' => $request->users ?? []
        ]);
    }
}
