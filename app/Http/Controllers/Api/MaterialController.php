<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index(Course $course)
    {
        $materials = $course->materials()->latest()->get();

        return response()->json([
            'status' => 'success',
            'course' => $course,
            'materials' => $materials
        ]);
    }

    public function show(Course $course, Material $material)
    {
        return response()->json([
            'status' => 'success',
            'course' => $course,
            'material' => $material
        ]);
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|url',
            'description' => 'nullable|string',
        ]);

        $material = $course->materials()->create([
            'title' => $request->title,
            'file' => $request->file,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Material added successfully',
            'material' => $material
        ]);
    }

    public function update(Request $request, Course $course, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|url',
            'description' => 'nullable|string',
        ]);

        $material->update($request->only('title', 'file', 'description'));

        return response()->json([
            'status' => 'success',
            'message' => 'Material updated successfully',
            'material' => $material
        ]);
    }

    public function destroy(Course $course, Material $material)
    {
        $material->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Material deleted successfully'
        ]);
    }
}
