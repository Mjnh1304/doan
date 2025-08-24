@extends('layouts.admin')

@section('title', 'Chỉnh sửa resort')

@section('content')
<div class="max-w-2xl mx-auto mt-6">
    <h1 class="text-2xl font-bold mb-4">Chỉnh sửa resort</h1>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.resorts.update', $resort->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold mb-1">Tên resort</label>
            <input type="text" name="name" value="{{ old('name', $resort->name) }}"
                class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-semibold mb-1">Vị trí</label>
            <input type="text" name="location" value="{{ old('location', $resort->location) }}"
                class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-semibold mb-1">Giá (VND)</label>
            <input type="number" name="price" value="{{ old('price', $resort->price) }}"
                class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-semibold mb-1">Mô tả</label>
            <textarea name="description" rows="4"
                class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description', $resort->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="panorama_url" class="block text-gray-700 font-bold mb-2">Link ảnh 360:</label>
            <input type="url" name="panorama_url" id="panorama_url"
                value="{{ old('panorama_url', $resort->panorama_url ?? '') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                placeholder="Dán link Momento360 hoặc URL ảnh 360 khác">
        </div>

        <div>
            <label class="block font-semibold mb-1">Ảnh hiện tại</label>
            @if ($resort->image)
            <img src="{{ asset('storage/' . $resort->image) }}" alt="Ảnh resorts" class="h-40 mb-2 rounded shadow">
            @else
            <p>Không có ảnh</p>
            @endif
            <input type="file" name="image" class="block mt-2">
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cập nhật</button>
        </div>
    </form>
    <div class="flex justify-end">
    <a href="{{ route('admin.resorts.index') }}" class="text-blue-500 hover:underline">← Quay lại danh sách</a>
</div>
</div>
@endsection