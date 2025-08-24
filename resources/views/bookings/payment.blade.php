@extends('layouts.app')

@section('content')
@php
$bookable = $booking->bookable;
$type = class_basename($booking->bookable_type);
$name = $bookable->name ?? 'Không rõ';
$image = $bookable->image ?? null;
@endphp
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md mt-6">
    <h2 class="text-2xl font-bold text-indigo-700 mb-4">{{ __('booking.confirm_booking') }}</h2>

    <div class="space-y-3 text-gray-800">
        <p><strong>Dịch vụ:</strong> {{ $booking->bookable->name }}<span class="block text-gray-700 white-space: nowrap;">({{ $type }})</span></p>
        <p><strong>{{ __('booking.check_in') }}:</strong> {{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}</p>
        <p><strong>{{ __('booking.check_out') }}:</strong> {{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}</p>
        <p><strong>{{ __('booking.guests') }}:</strong> {{ $booking->guests }}</p>
        <p><strong>{{ __('booking.total_price') }}:</strong> {{ number_format($booking->total_price, 0, ',', '.') }} VND</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('bookings.qr', $booking->id) }}"
            class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition">
            {{ __('booking.showqr') }}
        </a>

        <a href="{{ route('bookings.history') }}"
            class="ml-4 text-sm text-gray-600 hover:underline">
            {{ __('booking.cancel_and_back') }}
        </a>
    </div>
</div>
@include('layouts.partials.contact-floating')
@endsection
