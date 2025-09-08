@extends('layout.dashboard.app')

@section('title', 'Manage Courses')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manage Courses</h2>
        <a href="{{ route('manage-course.create') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Add Course</a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-md overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cover</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($courses as $course)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $course->category->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ \Illuminate\Support\Str::limit($course->description, 50) }}
                        </td>
                        <td class="px-6 py-4">
                            <img src="{{ $course->cover }}" alt="{{ $course->name }}"
                                class="w-16 h-10 object-cover rounded">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <a href="{{ route('manage-course.edit', $course->id) }}"
                                class="px-3 py-1 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition">Edit</a>
                            <a href="{{ route('material.index', $course->id) }}"
                                class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Details
                            </a>
                            <button type="button"
                                onclick="document.getElementById('assign-modal-{{ $course->id }}').classList.remove('hidden')"
                                class="px-3 py-1 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                Assign
                            </button>
                            <form action="{{ route('manage-course.destroy', $course) }}" method="POST"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <div id="assign-modal-{{ $course->id }}"
                        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                        <div class="bg-white rounded-2xl shadow-lg w-96 p-6">
                            <h3 class="text-lg font-bold mb-4">Assign Users to {{ $course->name }}</h3>
            
                            <form action="{{ route('manage-course.assign', $course->id) }}" method="POST">
                                @csrf
                                <div class="max-h-60 overflow-y-auto space-y-2">
                                    @foreach (\App\Models\User::all() as $user)
                                        <label class="flex items-center space-x-2">
                                            <input type="checkbox" name="users[]" value="{{ $user->id }}"
                                                {{ \App\Models\CourseUser::where('course_id', $course->id)->where('user_id', $user->id)->exists() ? 'checked' : '' }}>
                                            <span>{{ $user->name }} ({{ $user->email }})</span>
                                        </label>
                                    @endforeach
                                </div>
            
                                <div class="flex justify-end mt-4 space-x-2">
                                    <button type="button"
                                        onclick="document.getElementById('assign-modal-{{ $course->id }}').classList.add('hidden')"
                                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Cancel</button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
        <!-- Modal Assign -->

    </div>
@endsection
