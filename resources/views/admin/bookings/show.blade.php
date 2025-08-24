@extends('layouts.admin')

@section('title', 'Chi tiết đặt lịch')

@section('content')
<h1 class="text-2xl font-bold mb-4 text-center">Chi tiết phiếu đặt lịch #{{ $booking->id }}</h1>

<table class="table-auto w-full border">
    <tr>
        <td class="font-semibold border p-2">Người đặt</td>
        <td class="border p-2">{{ $booking->user->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td class="font-semibold border p-2">Email</td>
        <td class="border p-2">{{ $booking->user->email ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td class="font-semibold border p-2">Dịch vụ</td>
        <td class="border p-2">
            @if($booking->bookable)
            <a href="{{ route(strtolower(class_basename($booking->bookable_type)) . 's.show', $booking->bookable->id) }}" class="text-blue-600 hover:underline">
                {{ $booking->bookable->name }}
            </a>
            @else
            N/A
            @endif
        </td>

    </tr>
    <tr>
        <td class="font-semibold border p-2">Ngày nhận</td>
        <td class="border p-2">{{ $booking->check_in }}</td>
    </tr>
    <tr>
        <td class="font-semibold border p-2">Ngày trả</td>
        <td class="border p-2">{{ $booking->check_out }}</td>
    </tr>
    <tr>
        <td class="font-semibold border p-2">Số khách</td>
        <td class="border p-2">{{ $booking->guests }}</td>
    </tr>
    <tr>
        <td class="font-semibold border p-2">Tổng giá tiền</td>
        <td class="border p-2">{{ number_format($booking->total_price, 0, ',', '.') }} đ</td>
    </tr>

    <tr>
        <td class="font-semibold border p-2">Ghi chú</td>
        <td class="border p-2"><textarea name="notes" id="notes" rows="4" cols="50" disabled>{{ old('notes', $booking->notes) }}</textarea></td>
    </tr>
    <tr>
        <td class="font-semibold border p-2">Trạng thái</td>
        <td class="border p-2">{{ ucfirst(__("booking.status_{$booking->status}")) }}</td>
    </tr>
    <tr>
        <td class="font-semibold border p-2">Thời gian tạo</td>
        <td class="border p-2">{{ $booking->created_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>

<div class="mt-6 text-center">
    <a href="{{ route('admin.bookings.index') }}" class="text-blue-500 hover:underline">← Quay lại danh sách</a>
</div>
@endsection