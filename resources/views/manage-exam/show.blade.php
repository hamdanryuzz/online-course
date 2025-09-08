@extends('layout.dashboard.app')

@section('title', 'Manage Exam - ' . $course->name)

@section('content')
    <h2 class="text-2xl font-bold mb-6">Exams for {{ $course->name }}</h2>

    <!-- Button Add -->
    <button onclick="document.getElementById('addModal').classList.remove('hidden')"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg mb-4">+ Add Question</button>

    <!-- Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Question</th>
                    <th class="p-3">Options</th>
                    <th class="p-3">Answer</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($exams as $exam)
                    <tr class="border-t">
                        <td class="p-3">{{ $exam->question }}</td>
                        <td class="p-3">
                            <ul>
                                @foreach ($exam->options as $opt)
                                    <li>- {{ $opt }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="p-3 font-bold text-green-600">{{ $exam->answer }}</td>
                        <td class="p-3 flex gap-2">
                            <!-- Edit -->
                            <button onclick="document.getElementById('editModal-{{ $exam->id }}').classList.remove('hidden')"
                                class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</button>

                            <!-- Delete -->
                            <form action="{{ route('manage-exam.destroy', $exam->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div id="editModal-{{ $exam->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg p-6 w-96">
                            <h3 class="text-lg font-bold mb-4">Edit Question</h3>
                            <form action="{{ route('manage-exam.update', $exam->id) }}" method="POST">
                                @csrf @method('PUT')
                                <textarea name="question" class="w-full p-2 border rounded mb-3">{{ $exam->question }}</textarea>
                                @foreach ($exam->options as $opt)
                                    <input type="text" name="options[]" value="{{ $opt }}" class="w-full p-2 border rounded mb-2">
                                @endforeach
                                <input type="text" name="answer" value="{{ $exam->answer }}" class="w-full p-2 border rounded mb-3">
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Update</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Add -->
    <div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-lg font-bold mb-4">Add Question</h3>
            <form action="{{ route('manage-exam.store') }}" method="POST">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <textarea name="question" class="w-full p-2 border rounded mb-3" placeholder="Question" required></textarea>
                <input type="text" name="options[]" class="w-full p-2 border rounded mb-2" placeholder="Option 1" required>
                <input type="text" name="options[]" class="w-full p-2 border rounded mb-2" placeholder="Option 2" required>
                <input type="text" name="options[]" class="w-full p-2 border rounded mb-2" placeholder="Option 3">
                <input type="text" name="options[]" class="w-full p-2 border rounded mb-2" placeholder="Option 4">
                <input type="text" name="answer" class="w-full p-2 border rounded mb-3" placeholder="Correct Answer" required>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Save</button>
            </form>
        </div>
    </div>
@endsection
