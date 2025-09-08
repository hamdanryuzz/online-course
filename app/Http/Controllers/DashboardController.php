<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        return view('dashboard', [
            'courses'   => $this->getCourses(),
            'materials' => $this->getMaterials(),
            'users'     => $this->getUsers(),
        ]);
    }

    private function getCourses()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return Course::all();
        }

        if ($user->role === 'teacher') {
            return Course::where('user_id', $user->id)->get();
        }

        return collect();
    }

    private function getMaterials()
    {
        $user = Auth::user();

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

   private function getUsers()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return User::all();
        }

        if ($user->role === 'teacher') {
            return User::whereHas('courses', function ($query) use ($user) {
                $query->where('courses.user_id', $user->id); // pastikan pakai prefix
            })->get();
        }

        return collect();
    }


}
