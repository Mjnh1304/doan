<!-- resources/views/admin/dashboard.blade.php -->

@extends('layouts.admin')

@section('title', 'Trang Quản Trị')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Bảng điều khiển quản trị</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Tổng số villa -->
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Tổng số Villa</h2>
            <p class="text-3xl text-indigo-600 font-bold">{{ $villaCount }}</p>
        </div>

        <!-- Tổng số lượt đặt (nếu có) -->
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Lượt đặt</h2>
            <p class="text-3xl text-green-600 font-bold">{{ $bookingCount ?? 0 }}</p>
        </div>

        <!-- Tổng số người dùng (tùy chọn) -->
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Người dùng</h2>
            <p class="text-3xl text-orange-600 font-bold">{{ $userCount ?? 0 }}</p>
        </div>
    </div>
</div>
@endsection
