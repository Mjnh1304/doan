<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resort;
use App\Models\Booking;
use Carbon\Carbon;

class resortController extends Controller
{
      /**
     * Hiển thị chi tiết resort và các ngày đã được đặt
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $resort = resort::findOrFail($id);

        // Lấy tất cả booking của resort này từ hôm nay trở đi
        $bookings = $resort->bookings()
            ->where('check_out', '>=', now()->startOfDay())
            ->get();;

        $bookedDates = [];

        foreach ($bookings as $booking) {
            $start = \Carbon\Carbon::parse($booking->check_in);
            $end = \Carbon\Carbon::parse($booking->check_out);

            for ($date = $start; $date->lte($end); $date->addDay()) {
                $bookedDates[] = $date->format('Y-m-d');
            }
        }

        $bookedDates = [$resort->id => array_unique($bookedDates)];

        // Lấy danh sách đánh giá kèm người đánh giá

        $reviews = $resort->reviews()
            ->whereNull('parent_id')
            ->with(['user'])
            ->latest()
            ->take(5)
            ->get();

        $totalReviews = $resort->reviews()
            ->whereNull('parent_id')
            ->count();
        // Gửi thêm $reviews sang view
        return view('resorts.show', compact('resort', 'bookedDates', 'reviews', 'totalReviews'));
    }
    public function index(Request $request)
    {
        $query = resort::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $resorts = $query->with('reviews')->get();

        if ($request->filled('min_rating')) {
            $resorts = $resorts->filter(function ($resort) use ($request) {
                return $resort->reviews->avg('rating') >= $request->min_rating;
            });
        }

        // AJAX => chỉ render phần danh sách
        if ($request->ajax()) {
            return response()->view('resorts.index', compact('resorts'))->withHeaders([
                'X-Partial' => 'true'
            ]);
        }

        return view('resorts.index', compact('resorts'));
    }
}
