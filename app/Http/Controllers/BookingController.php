<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Villa;
use App\Models\Resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Vui lòng đăng nhập để đặt dịch vụ.',
            ], 401);
        }

        // Thêm xác thực bookable_type và bookable_id
        $validated = $request->validate([
            'bookable_type' => 'required|string|in:App\Models\Villa,App\Models\Resort',
            'bookable_id' => 'required|integer',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $checkIn = Carbon::parse($request->input('check_in'));
                    $checkOut = Carbon::parse($value);
                    if ($checkOut->lte($checkIn)) {
                        $fail('Ngày check-out phải sau ngày check-in ít nhất 1 ngày.');
                    }
                },
            ],
            'guests' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Lấy model tương ứng
        $bookableClass = $validated['bookable_type'];
        $bookable = $bookableClass::findOrFail($validated['bookable_id']);

        // Kiểm tra đơn chưa thanh toán hoặc chưa checkout (dành cho user)
        $hasOngoingBooking = Booking::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('is_paid', false)
                    ->orWhere('check_out', '>=', now());
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($hasOngoingBooking) {
            return response()->json([
                'message' => 'Bạn chỉ được đặt dịch vụ mới sau khi hoàn tất đơn hiện tại (thanh toán và checkout).',
            ], 422);
        }

        // Kiểm tra đã có booking trùng thời gian cho dịch vụ này chưa
        $exists = Booking::where('bookable_type', $bookableClass)
            ->where('bookable_id', $validated['bookable_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('check_in', [$validated['check_in'], $validated['check_out']])
                    ->orWhereBetween('check_out', [$validated['check_in'], $validated['check_out']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('check_in', '<=', $validated['check_in'])
                            ->where('check_out', '>=', $validated['check_out']);
                    });
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Dịch vụ đã có người đặt trong khoảng thời gian này!',
            ], 422);
        }

        $checkIn = Carbon::parse($validated['check_in'])->setTimezone('Asia/Ho_Chi_Minh')->startOfDay();
        $checkOut = Carbon::parse($validated['check_out'])->setTimezone('Asia/Ho_Chi_Minh')->startOfDay();

        if ($checkOut->lessThanOrEqualTo($checkIn)) {
            return response()->json([
                'message' => 'Ngày check-out phải sau ngày check-in ít nhất 1 ngày.',
            ], 422);
        }

        $days = $checkIn->diffInDays($checkOut);

        Log::info("Days: {$days}, Check-in: {$checkIn}, Check-out: {$checkOut}");

        $guests = (int) $validated['guests'];

        // Tính tổng tiền dựa trên loại dịch vụ
        $price = (float) $bookable->price ?? 0;
        $totalPrice = $price * $days * $guests;

        if ($price < 0 || $totalPrice < 0) {
            return response()->json([
                'message' => 'Giá không hợp lệ. Vui lòng liên hệ quản trị viên.',
            ], 422);
        }

        Booking::create([
            'user_id' => Auth::id(),
            'bookable_type' => $bookableClass,
            'bookable_id' => $bookable->id,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'guests' => $validated['guests'],
            'total_price' => $totalPrice,
            'is_paid' => false,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return response()->json([
            'message' => 'Đặt lịch thành công!',
            'price_per_day' => $price,
            'days' => $days,
            'guests' => $guests,
            'total_price' => $totalPrice,
        ]);
    }

    public function index()
    {
        // Lấy tất cả dịch vụ có thể đặt (ví dụ villa, resort)
        $villas = Villa::all();
        $resorts = Resort::all();

        $bookings = Booking::with('bookable')
        ->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();

        // Lấy tất cả booking confirmed
        $confirmedBookings = Booking::where('status', 'confirmed')->get();

        $bookedDates = [];

        foreach ($confirmedBookings as $booking) {
            $period = CarbonPeriod::create(
                Carbon::parse($booking->check_in),
                Carbon::parse($booking->check_out)->subDay()
            );
            $dates = [];
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }

            $key = $booking->bookable_type . '-' . $booking->bookable_id;
            if (!isset($bookedDates[$key])) {
                $bookedDates[$key] = [];
            }
            $bookedDates[$key] = array_merge($bookedDates[$key], $dates);
        }

        foreach ($bookedDates as $key => $dates) {
            $bookedDates[$key] = array_unique($dates);
        }

        return view('bookings.history', compact('villas', 'resorts', 'bookedDates','bookings'));
    }

    public function history()
    {
        $bookings = Booking::with('bookable')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookings.history', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with('bookable')->where('user_id', auth()->id())->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = Booking::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'confirmed','completed'])
            ->findOrFail($id);

        $booking->delete();

        return redirect()->back()->with('success', 'Đã hủy, xóa đơn đặt phòng thành công.');
    }

    public function showPaymentForm($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('is_paid', false)
            ->where('status', 'confirmed')
            ->firstOrFail();

        return view('bookings.payment', compact('booking'));
    }

    public function showQrCode($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'confirmed')
            ->firstOrFail();

        $qrData = 'Thông tin ngân hàng để chuyển khoản: '
            . 'Số tài khoản: 123456789 - Ngân hàng XYZ - Nội dung: BOOKING' . $booking->id;

        return view('bookings.qr', compact('booking', 'qrData'));
    }

    public function checkPaymentStatus($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->is_paid) {
            return redirect()->back()->with('checked', true);
        }

        return redirect()->back()->with('error', 'Thanh toán chưa được xác nhận. Hãy thử lại sau.');
    }

    public function processPayment($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('is_paid', false)
            ->where('status', 'confirmed')
            ->firstOrFail();

        // Fake payment
        $booking->is_paid = true;
        $booking->save();

        return redirect()->back()->with('success', 'Thanh toán thành công!');
    }
}