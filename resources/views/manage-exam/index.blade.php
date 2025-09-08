@extends('layout.dashboard.app')

@section('title', 'Manage Exam')

@section('content')
    <h2 class="text-2xl font-bold mb-6">Manage Exam</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($courses as $course)
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold mb-2">{{ $course->name }}</h3>
                <p class="text-gray-600 mb-4">{{ Str::limit($course->description, 50) }}</p>
                <p class="text-sm text-gray-500 mb-3">Total Questions: {{ $course->exams_count }}</p>
                <a href="{{ route('manage-exam.show', $course->id) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">View Exam</a>
            </div>
        @endforeach
    </div>
@endsection
