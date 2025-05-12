@extends('layouts.admin')

@section('title', 'Thêm Villa mới')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-semibold mb-6">Thêm Villa Mới</h2>

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

    <form action="{{ route('admin.villas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-medium">Tên Villa</label>
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
            <label class="block mb-1 font-medium">Hình ảnh</label>
            <input type="file" name="image" accept="image/*" class="w-full border-gray-300 rounded p-2">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.villas.index') }}" class="mr-4 text-gray-600 hover:underline">Quay lại</a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Thêm Villa
            </button>
        </div>
    </form>
</div>
@endsection
