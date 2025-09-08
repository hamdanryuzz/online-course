@extends('layout.dashboard.app')

@section('title', 'Manage Courses')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
            <h3 class="text-gray-500 mb-2">Total Courses</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $courses->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
            <h3 class="text-gray-500 mb-2">Total Materials</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $materials->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition">
            <h3 class="text-gray-500 mb-2">Total Users</h3>
            <p class="text-2xl font-bold text-gray-800">{{ $users->count() }}</p>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="bg-white rounded-2xl shadow-md overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($courses as $course)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ $course->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ $course->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ \Illuminate\Support\Str::limit($course->description, 50) }}
                        </td>
                        {{-- <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                    <a href="{{ route('admin.courses.edit', $course->id) }}"
                                        class="px-3 py-1 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition">Edit</a>
                                    <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                            Delete
                                        </button>
                                    </form>
                                </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </main>
    </div>
@endsection
