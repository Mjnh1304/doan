@extends('layouts.app')

@section('title', __('booking.detail_title', ['id' => $booking->id]))

@section('content')
@php
$bookable = $booking->bookable;
$type = class_basename($booking->bookable_type);
$name = $bookable->name ?? 'Không rõ';
$image = $bookable->image ?? null;
@endphp
<div class="max-w-3xl mx-auto bg-white p-6 shadow-md rounded-lg">
    <h1 class="text-2xl font-bold text-center mb-6">
        {{ __('booking.detail_title', ['id' => $booking->id]) }}
    </h1>

    <div class="mb-4">
        <strong class="block text-gray-700">{{ __('booking.bookable') }}:</strong>
        <p>{{ $booking->bookable->name ?? __('booking.unknown') }}<span class="block text-gray-700 white-space: nowrap;">({{ $type }})</span></p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">{{ __('booking.check_in') }}:</strong>
        <p>{{ $booking->check_in }}</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">{{ __('booking.check_out') }}:</strong>
        <p>{{ $booking->check_out }}</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">{{ __('booking.guests') }}:</strong>
        <p>{{ $booking->guests }}</p>
    </div>

    @if($booking->note)
    <div class="mb-4">
        <strong class="block text-gray-700">{{ __('booking.note') }}:</strong>
        <p>{{ $booking->note }}</p>
    </div>
    @endif

    <div class="mb-4">
        <strong class="block text-gray-700">{{ __('booking.status') }}:</strong>
        <p>{{ __('booking.status_' . $booking->status) }}</p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">{{ __('booking.payment') }}:</strong>
        <p class="text-sm {{ $booking->is_paid ? 'text-green-600' : 'text-red-500' }}">
            {{ $booking->is_paid ? __('booking.paid') : __('booking.unpaid') }}
            @if(!$booking->is_paid && $booking->status === 'confirmed')
            <a href="{{ route('bookings.pay.form', $booking->id) }}"
                class="text-sm text-blue-600 hover:underline inline-block mt-2 ml-2">
                {{ __('booking.payment') }}
            </a>
            @endif
        </p>
    </div>

    <div class="mb-4">
        <strong class="block text-gray-700">{{ __('booking.created_at') }}:</strong>
        <p>{{ $booking->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('bookings.history') }}" class="text-blue-600 hover:underline">
            ← {{ __('booking.back_to_history') }}
        </a>
    </div>
</div>
@include('layouts.partials.contact-floating')
@endsection