@extends('layouts.admin')

@section('title', 'Quản lý đặt lịch')

@section('content')
<h1 class="text-2xl font-bold mb-6 text-center">Quản lý đặt lịch</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Form tìm kiếm và lọc --}}
<form method="GET" action="{{ route('admin.bookings.index') }}" class="mb-4 flex flex-wrap gap-4 justify-center">
    <input type="text" name="id" value="{{ request('id') }}" placeholder="Tìm ID"
        class="border rounded px-3 py-2 w-28">

    <input type="text" name="user" value="{{ request('user') }}" placeholder="Người đặt"
        class="border rounded px-3 py-2 w-40">

    <select name="service_type" class="border rounded px-3 py-2">
        <option value="">-- Loại dịch vụ --</option>
        <option value="Villa" {{ request('service_type') === 'Villa' ? 'selected' : '' }}>Villa</option>
        <option value="Resort" {{ request('service_type') === 'Resort' ? 'selected' : '' }}>Resort</option>
    </select>

    <select name="status" class="border rounded px-3 py-2">
        <option value="">-- Trạng thái --</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
    </select>

    <select name="payment" class="border rounded px-3 py-2">
        <option value="">-- Thanh toán --</option>
        <option value="1" {{ request('payment') === '1' ? 'selected' : '' }}>Đã thanh toán</option>
        <option value="0" {{ request('payment') === '0' ? 'selected' : '' }}>Chưa thanh toán</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Lọc</button>
    <a href="{{ route('admin.bookings.index') }}" class="text-gray-600 px-4 py-2 hover:underline">Đặt lại</a>
</form>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Người đặt</th>
            <th class="border border-gray-300 px-4 py-2">Dịch vụ</th>
            <th class="border border-gray-300 px-4 py-2">Ngày nhận</th>
            <th class="border border-gray-300 px-4 py-2">Ngày trả</th>
            <th class="border border-gray-300 px-4 py-2">Số khách</th>
            <th class="border border-gray-300 px-4 py-2">Trạng thái</th>
            <th class="border border-gray-300 px-4 py-2">Thanh toán</th>
            <th class="border border-gray-300 px-4 py-2">Ngày tạo</th>
            <th class="border border-gray-300 px-4 py-2">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
        <tr>
            <td class="border border-gray-300 px-4 py-2 text-center">{{ $booking->id }}</td>
            <td class="border border-gray-300 px-4 py-2 text-center">{{ $booking->user->name ?? 'N/A' }}</td>
            <td class="border border-gray-300 px-4 py-2 text-center">{{ $booking->bookable->name ?? 'N/A' }}(loại: {{ class_basename($booking->bookable_type) }})</td>
            <td class="border border-gray-300 px-4 py-2 text-center">{{ $booking->check_in }}</td>
            <td class="border border-gray-300 px-4 py-2 text-center">{{ $booking->check_out }}</td>
            <td class="border border-gray-300 px-4 py-2 text-center">{{ $booking->guests }}</td>
            <td class="border border-gray-300 px-4 py-2 text-center">{{ ucfirst(__("booking.status_$booking->status")) }}</td>
            <td class="border border-gray-300 px-4 py-2 text-center">
                @if($booking->is_paid)
                <span class="text-green-600 font-semibold">Đã thanh toán</span>
                @else
                <span class="text-red-500 font-semibold">Chưa thanh toán</span>
                @endif
            </td>
            <td class="border border-gray-300 px-4 py-2 text-center">{{ $booking->created_at->format('d/m/Y H:i') }}</td>
            <td class="border border-gray-300 px-4 py-2 text-center">
                <a href="{{ route('admin.bookings.show', $booking->id) }}">🔎</a> |
                <a href="{{ route('admin.bookings.edit', $booking->id) }}">✏️</a> |
                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Xác nhận xóa?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none;border:none;color:red;cursor:pointer">🗑</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $bookings->links() }}
@endsection