<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Villa;
use App\Models\Booking;
use Carbon\Carbon;

class VillaController extends Controller
{
    /**
     * Hiển thị chi tiết villa và các ngày đã được đặt
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $villa = Villa::findOrFail($id);

        // Lấy tất cả booking của villa này từ hôm nay trở đi
        $bookings = $villa->bookings()
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

        $bookedDates = [$villa->id => array_unique($bookedDates)];

        // Lấy danh sách đánh giá kèm người đánh giá

        $reviews = $villa->reviews()
            ->whereNull('parent_id')
            ->with(['user'])
            ->latest()
            ->take(5)
            ->get();

        $totalReviews = $villa->reviews()
            ->whereNull('parent_id')
            ->count();
            
        // Gửi thêm $reviews sang view
        return view('villas.show', compact('villa', 'bookedDates', 'reviews', 'totalReviews'));
    }
    public function index(Request $request)
    {
        $query = Villa::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $villas = $query->with('reviews')->get();

        if ($request->filled('min_rating')) {
            $villas = $villas->filter(function ($villa) use ($request) {
                return $villa->reviews->avg('rating') >= $request->min_rating;
            });
        }

        // AJAX => chỉ render phần danh sách
        if ($request->ajax()) {
            return response()->view('villas.index', compact('villas'))->withHeaders([
                'X-Partial' => 'true'
            ]);
        }

        return view('villas.index', compact('villas'));
    }
}
