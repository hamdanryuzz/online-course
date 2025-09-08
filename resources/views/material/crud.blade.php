@extends('layout.dashboard.app')

@section('title', isset($material) ? 'Edit Material' : 'Add Material')

@section('content')
<h2 class="text-2xl font-bold mb-6">{{ isset($material) ? 'Edit Material' : 'Add Material' }}</h2>

<form action="{{ isset($material) ? route('material.update', ['course' => $course->id, 'material' => $material->id]) : route('material.store', $course->id) }}" 
      method="POST" class="bg-white p-6 rounded-2xl shadow-md space-y-4">
    @csrf
    @if(isset($material))
        @method('PUT')
    @endif

    <div>
        <label class="block mb-1 font-medium">Title</label>
        <input type="text" name="title" value="{{ isset($material) ? $material->title : old('title') }}" class="w-full p-3 border rounded-lg" required>
    </div>

    <div>
        <label class="block mb-1 font-medium">Video URL</label>
        <input type="url" name="file" value="{{ isset($material) ? $material->file : old('file') }}" class="w-full p-3 border rounded-lg" required>
    </div>

    <div>
        <label class="block mb-1 font-medium">Description</label>
        <textarea name="description" class="w-full p-3 border rounded-lg">{{ isset($material) ? $material->description : old('description') }}</textarea>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('material.index', $course->id) }}" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
            Back to Materials
        </a>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            {{ isset($material) ? 'Update' : 'Create' }}
        </button>
    </div>
</form>
@endsection