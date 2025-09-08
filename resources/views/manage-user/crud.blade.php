@extends('layout.dashboard.app')

@section('title', isset($user) ? 'Edit User' : 'Add User')

@section('content')
<h2 class="text-2xl font-bold mb-6">{{ isset($user) ? 'Edit User' : 'Add User' }}</h2>

<form action="{{ isset($user) ? route('manage-user.update', $user->id) : route('manage-user.store') }}" 
      method="POST" class="bg-white p-6 rounded-2xl shadow-md space-y-4">
    @csrf
    @if(isset($user))
        @method('PUT')
    @endif

    <div>
        <label class="block mb-1 font-medium">Name</label>
        <input type="text" name="name" value="{{ $user->name ?? old('name') }}" class="w-full p-3 border rounded-lg" required>
    </div>

    <div>
        <label class="block mb-1 font-medium">Email</label>
        <input type="email" name="email" value="{{ $user->email ?? old('email') }}" class="w-full p-3 border rounded-lg" required>
    </div>

    <div>
        <label class="block mb-1 font-medium">Password</label>
        <input type="password" name="password" class="w-full p-3 border rounded-lg" {{ isset($user) ? '' : 'required' }}>
        @if(isset($user))
            <small class="text-gray-400">Leave blank to keep current password</small>
        @endif
    </div>

    <div>
        <label class="block mb-1 font-medium">Role</label>
        <select name="role" class="w-full p-3 border rounded-lg" required>
            <option value="admin" {{ (isset($user) && $user->role === 'admin') ? 'selected' : '' }}>Admin</option>
            <option value="student" {{ (isset($user) && $user->role === 'student') ? 'selected' : '' }}>Student</option>
            <option value="teacher" {{ (isset($user) && $user->role === 'teacher') ? 'selected' : '' }}>Teacher</option>
        </select>
    </div>

    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        {{ isset($user) ? 'Update' : 'Create' }}
    </button>
</form>
@endsection
