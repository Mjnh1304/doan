@extends('layouts.app')

@section('content')

<div class="max-w-md mx-auto mt-12 bg-white shadow-xl rounded-2xl p-8 text-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ __('booking.last_step') }}</h2>

    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/qr-code.jpg') }}" alt="QR Code" class="w-64 h-64 rounded-lg border border-gray-300 shadow-md">
    </div>

    <div class="text-left text-gray-700 mb-6 space-y-2">
        <p><span class="font-semibold">📌 Booking ID:</span> #{{ $booking->id }}</p>
        <p><span class="font-semibold">{{ __('booking.amount') }}:</span> {{ number_format($booking->total_price, 0, ',', '.') }} VNĐ</p>
        <p>
            <span class="font-semibold">{{ __('booking.transfer_note') }}:</span><br>
            <span class="text-blue-700 font-semibold text-lg">
                BOOKING{{ $booking->id }}-{{ $booking->user->name }}
            </span>
        </p>
    </div>

    @if (session('checked') && $booking->is_paid)
    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 whitespace-nowrap">
         {{ __('booking.payment_just_checked') }}
    </div>
    @elseif ($booking->is_paid)
    <div class="bg-green-50 text-green-600 px-4 py-2 rounded mb-4 whitespace-nowrap">
        {{ __('booking.payment_confirmed') }}
    </div>
    @endif

    @if (session('error'))
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 whitespace-nowrap">
        ⚠️ {{ session('error') }}
    </div>
    @endif


    <div class="flex flex-col justify-center gap-4">
        <a href="{{ route('bookings.checkPayment', $booking->id) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-6 py-2 rounded-lg font-semibold transition duration-200 whitespace-nowrap">
            {{ __('booking.check_payment_status') }}
        </a>
        <a href="{{ route('bookings.history') }}"
            class="text-gray-600 hover:underline text-sm pt-2 whitespace-nowrap">
            {{ __('booking.back_to_history') }}
        </a>
    </div>

</div>

@include('layouts.partials.contact-floating') {{-- Nút liên hệ nổi --}}
@endsection