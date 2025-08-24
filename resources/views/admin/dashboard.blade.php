@extends('layouts.admin')

@section('title', 'Trang Quản Trị')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Bảng điều khiển quản trị</h1>

    <!-- Thống kê tổng quan -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    <!-- Tổng thu nhập -->
    <div class="bg-white p-6 rounded-lg shadow text-center">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Tổng thu nhập</h2>
        <p class="text-3xl text-rose-600 font-bold">
            {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}₫
        </p>
    </div>
    
    <!-- Tổng số villa -->
    <div class="bg-white p-6 rounded-lg shadow text-center">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Tổng số Villa</h2>
        <p class="text-3xl text-indigo-600 font-bold">{{ $villaCount }}</p>
    </div>

    <!-- Tổng số lượt đặt -->
    <div class="bg-white p-6 rounded-lg shadow text-center">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Tổng lượt đặt</h2>
        <p class="text-3xl text-green-600 font-bold">{{ $bookingCount ?? 0 }}</p>
    </div>

    <!-- Tổng số người dùng -->
    <div class="bg-white p-6 rounded-lg shadow text-center">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Người dùng</h2>
        <p class="text-3xl text-orange-600 font-bold">{{ $userCount ?? 0 }}</p>
    </div>

</div>

    <!-- Biểu đồ -->
    <div class="mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Thống kê lượt đặt theo tháng</h2>
        <canvas id="bookingChart" height="100"></canvas>
    </div>
    <!-- Biểu đồ doanh thu -->
    <div class="mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Thống kê doanh thu theo tháng</h2>
        <canvas id="revenueChart" height="100"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('bookingChart').getContext('2d');
const bookingChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($months) !!},
        datasets: [{
            label: 'Lượt đặt',
            data: {!! json_encode($bookingData) !!},
            backgroundColor: 'rgba(59, 130, 246, 0.5)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 1,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctxRevenue, {
    type: 'line',
    data: {
        labels: {!! json_encode($months) !!},
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: {!! json_encode($revenueData) !!},
            backgroundColor: 'rgba(16, 185, 129, 0.2)',
            borderColor: 'rgba(16, 185, 129, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3,
            pointRadius: 4,
            pointBackgroundColor: 'rgba(16, 185, 129, 1)',
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('vi-VN') + ' đ';
                    }
                }
            }
        }
    }
});
</script>
@endpush