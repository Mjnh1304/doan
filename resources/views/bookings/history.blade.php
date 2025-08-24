@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">{{ __('booking.history_title') }}</h2>

    @if($bookings->isEmpty())
    <p class="text-gray-600">{{ __('booking.no_bookings') }}</p>
    @else
    <div class="space-y-4">
        @foreach ($bookings as $booking)
        @php
            $bookable = $booking->bookable;
            $type = class_basename($booking->bookable_type);
            $name = $bookable->name ?? 'Không rõ';
            $image = $bookable->image ?? null;
        @endphp
        <div class="border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow transition">
            <h3 class="text-lg font-semibold text-indigo-600">
                {{ $name }} <span class="text-lg font-semibold text-indigo-600">({{ $type }})</span>
            </h3>

            <img src="{{ $image ? asset('storage/' . $image) : asset('images/default.jpg') }}"
                alt="{{ $name }}"
                class="w-full h-48 object-cover rounded mb-2">

            <p class="text-gray-700">{{ __('booking.check_in') }}: {{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}</p>
            <p class="text-gray-700">{{ __('booking.check_out') }}: {{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}</p>
            <p class="text-gray-700">{{ __('booking.guests') }}: {{ $booking->guests }}</p>
            <p class="text-gray-700 font-medium">{{ __('booking.total_price') }}: {{ number_format($booking->total_price, 0, ',', '.') }} VND</p>

            <a href="{{ route('bookings.show', $booking->id) }}"
                class="inline-block mt-2 text-indigo-600 hover:underline text-sm">
                {{ __('booking.view_details') }}
            </a>

            @if(in_array($booking->status, ['pending', 'confirmed','completed']))
            <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="inline-block mt-2 ml-2">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-red-600 hover:underline text-sm"
                    onclick="return confirm('{{ __('booking.confirm_cancel') }}')">
                    {{ __('booking.cancel_booking') }}
                </button>
            </form>
            @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
@include('layouts.partials.contact-floating') {{-- Nút liên hệ nổi --}}
@endsection
