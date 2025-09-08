<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseDetailController extends Controller
{
    public function index($id)
{
    $course = Course::with('materials')->findOrFail($id);

    return view('course-detail', compact('course'));
}
}
