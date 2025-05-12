@extends('layouts.admin')

@section('title', 'Chỉnh sửa người dùng')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Chỉnh sửa vai trò: {{ $user->name }}</h2>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email:</label>
            <p class="text-gray-900">{{ $user->email }}</p>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Vai trò</label>
            <select name="role" id="role" class="w-full mt-1 border rounded p-2">
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Cập nhật
        </button>
    </form>
</div>
@endsection
