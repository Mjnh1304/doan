@extends('layouts.admin')

@section('title', 'Thêm resort mới')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-6">Thêm resort Mới</h2>

    @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
        <strong>Có lỗi xảy ra:</strong>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.resorts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-medium">Tên resort</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded p-2" required value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Vị trí</label>
            <input type="text" name="location" class="w-full border-gray-300 rounded p-2" required value="{{ old('location') }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Giá (VND)</label>
            <input type="number" name="price" class="w-full border-gray-300 rounded p-2" required value="{{ old('price') }}">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Mô tả</label>
            <textarea name="description" class="w-full border-gray-300 rounded p-2">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="panorama_url" class="block text-gray-700 font-bold mb-2">Link ảnh 360:</label>
            <input type="url" name="panorama_url" id="panorama_url"
                value="{{ old('panorama_url', $resort->panorama_url ?? '') }}"
                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"
                placeholder="Dán link Momento360 hoặc URL ảnh 360 khác">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-medium">Hình ảnh</label>
            <input type="file" name="image" accept="image/*" class="w-full border-gray-300 rounded p-2">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.resorts.index') }}" class="mr-4 text-gray-600 hover:underline">Quay lại</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Thêm resort
            </button>
        </div>
    </form>
</div>
@endsection