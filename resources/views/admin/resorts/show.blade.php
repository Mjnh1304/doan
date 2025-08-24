@extends('layouts.admin')

@section('title', 'Chi tiết resort')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-6">Chi tiết resort</h2>

    <div class="mb-4">
        <strong class="block text-gray-700">Tên resorts:</strong>
        <p>{{ $resort->name }}</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">Địa chỉ:</strong>
        <p>{{ $resort->location }}</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">Giá:</strong>
        <p>{{ number_format($resort->price, 0, ',', '.') }} VND</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">Mô tả:</strong>
        <p>{{ $resort->description }}</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">Hình ảnh:</strong><br>
        @if ($resort->image)
            <img src="{{ asset('storage/' . $resort->image) }}" class="w-64 rounded" alt="resorts Image">
        @else
            <p class="text-gray-500 italic">Không có hình ảnh</p>
        @endif
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.resorts.index') }}" class="text-blue-600 hover:underline">← Quay lại danh sách</a>
    </div>
</div>
@endsection
