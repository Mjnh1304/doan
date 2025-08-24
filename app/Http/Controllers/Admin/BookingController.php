<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'bookable']);

        // Tìm kiếm theo ID
        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        // Tìm kiếm theo tên người dùng
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user . '%');
            });
        }

        // Lọc theo loại dịch vụ (bookable_type)
        if ($request->filled('service_type')) {
            $query->where('bookable_type', 'App\\Models\\' . $request->service_type);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo thanh toán
        if ($request->filled('payment')) {
            $query->where('is_paid', $request->payment);
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }


    public function show($id)
    {
        $booking = Booking::with(['user', 'bookable'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.bookings.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string',
            'is_paid' => 'required|in:0,1',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->is_paid = $request->is_paid;
        $booking->notes = $request->notes;
        $booking->save();

        return redirect()->route('admin.bookings.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Xóa thành công');
    }
}
