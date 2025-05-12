@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Danh sách Villa</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($villas as $villa)
        <div class="border rounded shadow p-4 bg-white">
            <img src="{{ asset('images/' . $villa->image) }}" alt="{{ $villa->name }}" class="w-full h-48 object-cover rounded">
            <h2 class="text-xl font-semibold mt-4">{{ $villa->name }}</h2>
            <p class="text-gray-600">Địa điểm: {{ $villa->location }}</p>
            <p class="text-gray-600">Giá: {{ number_format($villa->price, 0, ',', '.') }} VND</p>

            <a href="{{ route('villas.show', $villa->id) }}" class="block mt-3 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded">
                Xem chi tiết & Đặt lịch
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
