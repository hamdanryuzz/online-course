@extends('layout.dashboard.app')

@section('title', 'Manage Users')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Manage Users</h2>
    <a href="{{ route('manage-user.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Add User</a>
</div>

@if(session('success'))
<div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-2xl shadow-md overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $user)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $user->role }}</td>
                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                    <a href="{{ route('manage-user.edit', $user->id) }}" class="px-3 py-1 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition">Edit</a>
                    <form action="{{ route('manage-user.destroy', $user->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
