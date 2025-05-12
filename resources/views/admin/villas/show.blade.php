@extends('layouts.admin')

@section('title', 'Chi tiết Villa')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-6">Chi tiết Villa</h2>

    <div class="mb-4">
        <strong class="block text-gray-700">Tên Villa:</strong>
        <p>{{ $villa->name }}</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">Địa chỉ:</strong>
        <p>{{ $villa->location }}</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">Giá:</strong>
        <p>{{ number_format($villa->price, 0, ',', '.') }} VND</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">Mô tả:</strong>
        <p>{{ $villa->description }}</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">Hình ảnh:</strong><br>
        @if ($villa->image)
            <img src="{{ asset('storage/' . $villa->image) }}" class="w-64 rounded" alt="Villa Image">
        @else
            <p class="text-gray-500 italic">Không có hình ảnh</p>
        @endif
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.villas.index') }}" class="text-blue-600 hover:underline">← Quay lại danh sách</a>
    </div>
</div>
@endsection
