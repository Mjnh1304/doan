@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Danh sách người dùng</h1>

    <!-- Form lọc -->
<form method="GET" class="mb-6 flex flex-wrap gap-4">
    <input type="text" name="search" value="{{ request('search') }}"
        placeholder="Tìm tên hoặc email" class="border px-4 py-2 rounded w-64">

    <select name="role" class="border px-4 py-2 rounded">
        <option value="">-- Tất cả vai trò --</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
    </select>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lọc</button>
</form>

    @if (session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Tên</th>
                <th class="border border-gray-300 px-4 py-2">Email</th>
                <th class="border border-gray-300 px-4 py-2">Vai trò</th>
                <th class="border border-gray-300 px-4 py-2">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $user->name }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $user->role }}</td>
                <td class="border border-gray-300 px-4 py-2">
                    @if ($user->role !== 'admin')
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Xoá người dùng này?')" class="text-red-600 hover:underline">Xoá</button>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline mr-2">Chỉnh sửa</a>
                    </form>
                    @else
                    <span class="text-gray-500">Không thể xoá</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-6">
    {{ $users->appends(request()->query())->links() }}
</div>
</div>
@endsection