@extends('layout.dashboard.app')

@section('title', $course->name . ' - Materials')

@section('content')
    <h2 class="text-2xl font-bold mb-6">{{ $course->name }} - Materials</h2>

    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('manage-course.index') }}" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
            Back to Courses
        </a>
        <a href="{{ route('material.create', $course->id) }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Add Material
        </a>
    </div>

    @if ($materials->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($materials as $material)
                <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition overflow-hidden flex flex-col">
                    <div class="h-40 bg-gray-900 flex items-center justify-center">
                        @if ($material->file)
                            <iframe class="w-full h-full" src="{{ $material->file }}" frameborder="0"
                                allowfullscreen></iframe>
                        @else
                            <p class="text-gray-400">No video</p>
                        @endif
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $material->title }}</h3>
                        <p class="text-gray-600 flex-1">{{ \Illuminate\Support\Str::limit($material->description, 80) }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <div class="space-x-2">
                                <a href="{{ route('material.edit', ['course' => $course->id, 'material' => $material->id]) }}"
                                    class="px-3 py-1 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition text-sm">Edit</a>
                                
                                <form action="{{ route('material.destroy', ['course' => $course->id, 'material' => $material->id]) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                            <span class="text-gray-400 text-sm">{{ $material->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No materials available for this course.</p>
    @endif
@endsection