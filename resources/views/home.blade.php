@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-10">{{ __('messages.home.explore_services') }}</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <a href="{{ route('villas.index') }}" class="relative group overflow-hidden rounded-xl shadow-md aspect-square">
            <img src="/images/villa.jpg" alt="Villa"
                class="w-full h-full object-cover transition duration-500 ease-in-out brightness-50 group-hover:brightness-100 group-hover:scale-105">
            <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 group-hover:opacity-0">
                <div class="text-center bg-black bg-opacity-50 px-4 py-2 rounded-md">
                    <h2 class="text-white text-lg font-semibold uppercase tracking-wide">Villa</h2>
                    <div class="mt-1 w-10 h-0.5 bg-white mx-auto"></div>
                </div>
            </div>
        </a>

        <a href="{{ route('resorts.index') }}" class="relative group overflow-hidden rounded-xl shadow-md aspect-square">
            <img src="/images/resort.jpg" alt="Resort"
                class="w-full h-full object-cover transition duration-500 ease-in-out brightness-50 group-hover:brightness-100 group-hover:scale-105">
            <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 group-hover:opacity-0">
                <div class="text-center bg-black bg-opacity-50 px-4 py-2 rounded-md">
                    <h2 class="text-white text-lg font-semibold uppercase tracking-wide">Resort</h2>
                    <div class="mt-1 w-10 h-0.5 bg-white mx-auto"></div>
                </div>
            </div>
        </a>

        <a href="{{ route('homestays.index') }}" class="relative group overflow-hidden rounded-xl shadow-md aspect-square">
            <img src="/images/homestay.jpg" alt="Homestay"
                class="w-full h-full object-cover transition duration-500 ease-in-out brightness-50 group-hover:brightness-100 group-hover:scale-105">
            <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 group-hover:opacity-0">
                <div class="text-center bg-black bg-opacity-50 px-4 py-2 rounded-md">
                    <h2 class="text-white text-lg font-semibold uppercase tracking-wide">Homestay</h2>
                    <div class="mt-1 w-10 h-0.5 bg-white mx-auto"></div>
                </div>
            </div>
        </a>

        <a href="{{ route('flights.index') }}" class="relative group overflow-hidden rounded-xl shadow-md aspect-square">
            <img src="/images/flight.jpg" alt="Vé máy bay"
                class="w-full h-full object-cover transition duration-500 ease-in-out brightness-50 group-hover:brightness-100 group-hover:scale-105">
            <div class="absolute inset-0 flex items-center justify-center transition-opacity duration-300 group-hover:opacity-0">
                <div class="text-center bg-black bg-opacity-50 px-4 py-2 rounded-md">
                    <h2 class="text-white text-lg font-semibold uppercase tracking-wide">{{ __('messages.home.flights') }}</h2>
                    <div class="mt-1 w-10 h-0.5 bg-white mx-auto"></div>
                </div>
            </div>
        </a>
    </div>
</div>
@include('layouts.partials.contact-floating') {{-- Nút liên hệ nổi --}}
@endsection
