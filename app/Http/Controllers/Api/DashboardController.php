<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'courses' => $this->getCourses($user),
            'materials' => $this->getMaterials($user),
            'users' => $this->getUsers($user),
        ]);
    }

    private function getCourses($user)
    {
        if ($user->role === 'admin') {
            return Course::all();
        }

        if ($user->role === 'teacher') {
            return Course::where('user_id', $user->id)->get();
        }

        return collect();
    }

    private function getMaterials($user)
    {
        if ($user->role === 'admin') {
            return Material::all();
        }

        if ($user->role === 'teacher') {
            return Material::whereHas('course', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        }

        return collect();
    }

    private function getUsers($user)
    {
        if ($user->role === 'admin') {
            return User::all();
        }

        if ($user->role === 'teacher') {
            return User::whereHas('courses', function ($query) use ($user) {
                $query->where('courses.user_id', $user->id);
            })->get();
        }

        return collect();
    }
}
