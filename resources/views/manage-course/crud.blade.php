@extends('layout.dashboard.app')

@section('title', isset($course) ? 'Edit Course' : 'Add Course')

@section('content')
    <h2 class="text-2xl font-bold mb-6">{{ isset($course) ? 'Edit Course' : 'Add Course' }}</h2>

    <form action="{{ isset($course) ? route('manage-course.update', $course->id) : route('manage-course.store') }}"
        method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl shadow-md space-y-4">
        @csrf
        @if (isset($course))
            @method('PUT')
        @endif

        <div>
            <label class="block mb-1 font-medium">Name</label>
            <input type="text" name="name" value="{{ $course->name ?? old('name') }}" class="w-full p-3 border rounded-lg"
                required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Category</label>
            <select name="category_id" class="w-full p-3 border rounded-lg" required>
                <option value="">-- Select Category --</option>
                @foreach (\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}"
                        {{ (isset($course) && $course->category_id == $category->id) || old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <div>
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" class="w-full p-3 border rounded-lg">{{ $course->description ?? old('description') }}</textarea>
        </div>

        <div>
            <label class="block mb-1 font-medium">Cover</label>
            <input type="file" name="cover" class="w-full p-2 border rounded-lg"
                {{ isset($course) ? '' : 'required' }}>
            @if (isset($course))
                <img src="{{ $course->cover }}" alt="{{ $course->name }}" class="mt-2 w-32 h-20 object-cover rounded">
            @endif
        </div>

        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            {{ isset($course) ? 'Update' : 'Create' }}
        </button>
    </form>
@endsection
