@extends('layouts.admin')

@section('title', 'Danh sách Villa')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-villa.css') }}">
@endpush

@section('content')
<div class="container mx-auto px-4 overflow-x-auto">
    <h1 class="text-2xl font-bold mb-6 text-center">Quản lý Villa</h1>

    @if (session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.villas.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Thêm Villa
        </a>
    </div>

    <table class="max-w-6xl mx-auto table-fixed border-separate border-spacing-0 border border-gray-200 shadow-sm rounded-lg">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">Tên</th>
                <th class="border border-gray-300 px-4 py-2">Vị trí</th>
                <th class="border border-gray-300 px-4 py-2">Giá (VND)</th>
                <th class="border border-gray-300 px-4 py-2">Mô tả</th>
                <th class="border border-gray-300 px-4 py-2 w-6">Ảnh</th>
                <th class="border border-gray-300 px-4 py-2">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($villas as $villa)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $villa->name }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $villa->location }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ number_format($villa->price, 0, ',', '.') }}</td>
                <td class="border border-gray-200 px-4 py-2 w-48 break-words align-top short-description">
                    {{ $villa->description ?? 'Chưa có mô tả' }}
                </td>
                <td class="border border-gray-300 px-4 py-2 text-center">
                    @if ($villa->image)
                    <img src="{{ asset('storage/' . $villa->image) }}" alt="{{ $villa->name }}" width="160" height="120" class="object-contain rounded mx-auto">
                    @else
                    <span class="text-gray-500">Chưa có ảnh</span>
                    @endif
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    <a href="{{ route('admin.villas.edit', $villa->id) }}" class="text-blue-600 hover:underline">Sửa</a>
                    |
                    <form action="{{ route('admin.villas.destroy', $villa->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa villa này?')" class="text-red-600 hover:underline">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="border border-gray-300 px-4 py-2 text-center">Chưa có villa nào</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $villas->links() }}
    </div>
</div>
@endsection