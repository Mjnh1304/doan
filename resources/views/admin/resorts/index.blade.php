@extends('layouts.admin')

@section('title', 'Danh sách resort')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-resort.css') }}">
@endpush

@section('content')
<div class="container mx-auto px-4 overflow-x-auto">
    <h1 class="text-2xl font-bold mb-6 text-center">Quản lý Resort</h1>

    @if (session('success'))
    <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    {{-- Thanh điều khiển gồm: nút thêm + form lọc --}}
<div class="mb-4 flex flex-wrap justify-between items-center gap-4">

    {{-- Nút thêm resort --}}
    <div>
        <a href="{{ route('admin.resorts.create') }}" class="bg-blue-500 text-white px-5 py-2.5 rounded hover:bg-blue-600">
            + Thêm Resort
        </a>
    </div>

    {{-- Form tìm kiếm và lọc --}}
    <form method="GET" action="{{ route('admin.resorts.index') }}" class="flex flex-wrap gap-2 items-center">
        <input type="text" name="keyword" value="{{ request('keyword') }}"
            placeholder="Tìm theo tên hoặc vị trí"
            class="border rounded px-3 py-2 w-60">

        <select name="sort" class="border rounded px-3 py-2">
            <option value="">Sắp xếp theo</option>
            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lọc</button>
        <a href="{{ route('admin.resorts.index') }}" class="text-gray-600 px-4 py-2 hover:underline">Đặt lại</a>
    </form>

</div>

    {{-- Bảng danh sách --}}
    <table class="w-full max-w-7xl mx-auto table-fixed border border-gray-200 shadow-sm rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-sm">
                <th class="w-[100px] border px-2 py-2">Tên</th>
                <th class="w-[90px] border px-2 py-2">Vị trí</th>
                <th class="w-[90px] border px-2 py-2">Giá (VND)</th>
                <th class="w-[250px] border px-2 py-2">Mô tả</th>
                <th class="w-[100px] border px-2 py-2">Ảnh 360</th>
                <th class="w-[180px] border px-2 py-2">Ảnh</th>
                <th class="w-[70px] border px-2 py-2">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($resorts as $resort)
            <tr class="villa-row">
                <td class="border px-2 py-2 text-center truncate" title="{{ $resort->name }}">
                    {{ $resort->name }}
                </td>
                <td class="border px-2 py-2 text-center truncate" title="{{ $resort->location }}">
                    {{ $resort->location }}
                </td>
                <td class="border px-2 py-2 text-center whitespace-nowrap truncate">
                    {{ number_format($resort->price, 0, ',', '.') }} đ
                </td>
                <td class="border px-2 py-2 text-left break-words text-sm">
                    {{ Str::limit($resort->description ?? 'Chưa có mô tả', 100, '...') }}
                </td>
                <td class="border px-2 py-2 text-center">
                    @if ($resort->panorama_url)
                    <a href="{{ $resort->panorama_url }}" target="_blank" class="text-blue-600 underline">Xem ảnh 360</a>
                    @else
                    <span class="text-gray-500">Chưa có</span>
                    @endif
                </td>
                <td class="border px-2 py-2 text-center">
                    @if ($resort->image)
                    <img src="{{ asset('storage/' . $resort->image) }}" alt="{{ $resort->name }}"
                        class="villa-image mx-auto w-[160px] h-[120px]">
                    @else
                    <span class="text-gray-500">Chưa có ảnh</span>
                    @endif
                </td>
                <td class="border px-2 py-2 text-center whitespace-nowrap text-sm">
                    <a href="{{ route('admin.resorts.edit', $resort->id) }}" class="text-blue-600 hover:underline">✏️</a>
                    |
                    <form action="{{ route('admin.resorts.destroy', $resort->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa resort này?')" class="text-red-600 hover:underline">🗑</button>
                    </form>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="6" class="border border-gray-300 px-4 py-2 text-center">Chưa có resort nào</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Phân trang --}}
    <div class="mt-4 flex justify-center">
        {{ $resorts->links() }}
    </div>
</div>
@endsection