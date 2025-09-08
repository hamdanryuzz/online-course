<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Material;

class MaterialController extends Controller
{
    public function index(Course $course)
    {
        $materials = $course->materials()->latest()->get();
        return view('material.material', compact('course', 'materials'));
    }

    public function create(Course $course)
    {
        return view('material.crud', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|url',
            'description' => 'nullable|string',
        ]);

        $course->materials()->create([
            'title' => $request->title,
            'file' => $request->file,
            'description' => $request->description,
        ]);

        return redirect()->route('material.index', $course->id)->with('success', 'Material added successfully.');
    }

    public function edit(Course $course, Material $material)
    {
        return view('material.crud', compact('course', 'material'));
    }

    public function update(Request $request, Course $course, Material $material)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|url',
            'description' => 'nullable|string',
        ]);

        $material->update($request->only('title', 'file', 'description'));

        return redirect()->route('material.index', $course->id)->with('success', 'Material updated successfully.');
    }

    // Perbaikan parameter method destroy
    public function destroy(Course $course, Material $material)
    {
        $material->delete();
        return redirect()->route('material.index', $course->id)->with('success', 'Material deleted successfully.');
    }
}