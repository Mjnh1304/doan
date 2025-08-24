@extends('layouts.admin')

@section('content')
<h1>Sửa đặt lịch #{{ $booking->id }}</h1>

<form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="status">Trạng thái:</label>
    <select name="status" id="status" required>
        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
        <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Hoàn tất</option>
    </select>
    <br><br>

    <label>Xác nhận thanh toán:</label><br>
    <label>
        <input type="radio" name="is_paid" value="0" {{ !$booking->is_paid ? 'checked' : '' }}>
        Chưa thanh toán
    </label><br>
    <label>
        <input type="radio" name="is_paid" value="1" {{ $booking->is_paid ? 'checked' : '' }}>
        Đã thanh toán
    </label>
    <br><br>

    <label for="notes">Ghi chú:</label><br>
    <textarea name="notes" id="notes" rows="4" cols="50">{{ old('notes', $booking->notes) }}</textarea>
    <br><br>

    <button type="submit">Lưu</button>
</form>

<a href="{{ route('admin.bookings.index') }}">Quay lại</a>
@endsection