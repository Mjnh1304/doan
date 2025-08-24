<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Villa;
use App\Models\User;
use App\Models\Booking;

class AdminController extends Controller
{
    public function index()
    {
        $villaCount = Villa::count();
        $userCount = User::count();
        $bookingCount = Booking::count();

        $months = [];
        $bookingData = [];
        $revenueData = [];

        $totalRevenue = Booking::where('status', 'completed')->sum('total_price');

        for ($i = 1; $i <= 6; $i++) {
            $months[] = 'Tháng ' . $i;

            // Lượt đặt theo tháng
            $bookingData[] = Booking::whereMonth('created_at', $i)
                ->whereYear('created_at', now()->year)
                ->count();

            // Tổng doanh thu theo tháng (giả sử cột lưu tiền là 'total_price')
            $revenueData[] = Booking::whereMonth('created_at', $i)
                ->whereYear('created_at', now()->year)
                ->where('status', 'completed')
                ->sum('total_price');
        }

        return view('admin.dashboard', compact(
            'villaCount',
            'userCount',
            'bookingCount',
            'months',
            'bookingData',
            'revenueData',
            'totalRevenue'
        ));
    }
}
