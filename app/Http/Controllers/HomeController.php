<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $courses = $this->getCourses();
        
        return view('home', compact('courses','categories'));
    }

    private function getCourses()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return Course::all();
        }

        if ($user->role === 'student') {
            return Course::whereHas('users', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->get();
        }

        return collect();
    }
}
