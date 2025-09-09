<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $categories = Category::all();

        // Filter courses berdasarkan role
        if ($user->role === 'admin') {
            $courses = Course::with('category')->get();
        } elseif ($user->role === 'student') {
            $courses = Course::with('category')
                ->whereHas('users', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->get();
        } else {
            $courses = collect(); // kosong jika role lain
        }

        return response()->json([
            'status' => 'success',
            'categories' => $categories,
            'courses' => $courses
        ]);
    }
}
