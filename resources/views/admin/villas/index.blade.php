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

    {{-- Thanh điều khiển gồm: nút thêm + form lọc --}}
<div class="mb-4 flex flex-wrap justify-between items-center gap-4">

    {{-- Nút thêm villa --}}
    <div>
        <a href="{{ route('admin.villas.create') }}" class="bg-blue-500 text-white px-5 py-2.5 rounded hover:bg-blue-600">
            + Thêm Villa
        </a>
    </div>

    {{-- Form tìm kiếm và lọc --}}
    <form method="GET" action="{{ route('admin.villas.index') }}" class="flex flex-wrap gap-2 items-center">
        <input type="text" name="keyword" value="{{ request('keyword') }}"
            placeholder="Tìm theo tên hoặc vị trí"
            class="border rounded px-3 py-2 w-60">

        <select name="sort" class="border rounded px-3 py-2">
            <option value="">Sắp xếp theo</option>
            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lọc</button>
        <a href="{{ route('admin.villas.index') }}" class="text-gray-600 px-4 py-2 hover:underline">Đặt lại</a>
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
            @forelse ($villas as $villa)
            <tr class="villa-row">
                <td class="border px-2 py-2 text-center truncate" title="{{ $villa->name }}">
                    {{ $villa->name }}
                </td>
                <td class="border px-2 py-2 text-center truncate" title="{{ $villa->location }}">
                    {{ $villa->location }}
                </td>
                <td class="border px-2 py-2 text-center whitespace-nowrap truncate">
                    {{ number_format($villa->price, 0, ',', '.') }} đ
                </td>
                <td class="border px-2 py-2 text-left break-words text-sm">
                    {{ Str::limit($villa->description ?? 'Chưa có mô tả', 100, '...') }}
                </td>
                <td class="border px-2 py-2 text-center">
                    @if ($villa->panorama_url)
                    <a href="{{ $villa->panorama_url }}" target="_blank" class="text-blue-600 underline">Xem ảnh 360</a>
                    @else
                    <span class="text-gray-500">Chưa có</span>
                    @endif
                </td>
                <td class="border px-2 py-2 text-center">
                    @if ($villa->image)
                    <img src="{{ asset('storage/' . $villa->image) }}" alt="{{ $villa->name }}"
                        class="villa-image mx-auto w-[160px] h-[120px]">
                    @else
                    <span class="text-gray-500">Chưa có ảnh</span>
                    @endif
                </td>
                <td class="border px-2 py-2 text-center whitespace-nowrap text-sm table-action">
                    <a href="{{ route('admin.villas.edit', $villa->id) }}" class="text-blue-600 hover:underline">✏️</a>
                    |
                    <form action="{{ route('admin.villas.destroy', $villa->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa villa này?')" class="text-red-600 hover:underline">🗑</button>
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

    {{-- Phân trang --}}
    <div class="mt-4 flex justify-center">
        {{ $villas->links() }}
    </div>
</div>
@endsection