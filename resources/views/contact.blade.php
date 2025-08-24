@extends('layouts.app')
@section('title', 'Liên hệ')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-10 text-center text-gray-800">{{ __('messages.contact_with_us') }}</h1>

    <div class="grid md:grid-cols-2 gap-10 bg-white p-6 rounded-xl shadow-md">
        {{-- Thông tin liên hệ --}}
        <div class="space-y-6">
            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 text-blue-600 mt-1" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                     d="M17.657 16.657L13.414 12.414a1 1 0 00-1.414 0l-4.243 4.243m0 0A8 8 0 1117.657 6.343a8 8 0 010 11.314z"/>
                </svg>
                <div>
                    <p class="font-semibold text-gray-700">{{ __('messages.address') }}:</p>
                    <p class="text-gray-600">Sóc Sơn, Hà Nội</p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 text-green-600 mt-1" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                     d="M3 5h2l.4 2M7 10h10l1 2H6l1-2zm3 6h4l1 2H9l1-2zM3 5l2 12h14l2-12H3z"/>
                </svg>
                <div>
                    <p class="font-semibold text-gray-700">{{ __('messages.phone_number') }}:</p>
                    <p><a href="tel:0374765197" class="text-blue-600 hover:underline">0374765197 - Nguyễn Hữu Minh</a></p>
                    <p><a href="tel:0378243365" class="text-blue-600 hover:underline">0378243365 - Nguyễn Thị Thu Thủy</a></p>
                </div>
            </div>

            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 text-red-500 mt-1" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                     d="M16 12a4 4 0 01-8 0M3.055 11H5a2 2 0 002-2V7a4 4 0 014-4h2a4 4 0 014 4v2a2 2 0 002 2h1.945a2 2 0 012 2v2a2 2 0 01-2 2H19a2 2 0 00-2 2v2a4 4 0 01-4 4h-2a4 4 0 01-4-4v-2a2 2 0 00-2-2H3.055a2 2 0 01-2-2v-2a2 2 0 012-2z"/>
                </svg>
                <div>
                    <p class="font-semibold text-gray-700">Email:</p>
                    <p><a href="mailto:minh13042003a@gmail.com" class="text-blue-600 hover:underline">minh13042003a@gmail.com</a></p>
                    <p><a href="mailto:thuynguyen275197@gmail.com" class="text-blue-600 hover:underline">thuynguyen275197@gmail.com</a></p>
                </div>
            </div>
        </div>

        {{-- Bản đồ (nếu muốn chèn Google Maps) --}}
        <div>
            <iframe class="w-full h-72 rounded-lg shadow"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.8217010542054!2d105.79301147467976!3d21.000157788733906!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135accb8d8fa6b3%3A0x343f0a30e2ac6f1a!2zU8ahYyBTw7RuLCBIw6AgTuG7mWkgTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1sen!2s!4v1618923419393!5m2!1sen!2s"
                    style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</div>
@include('layouts.partials.contact-floating') {{-- Nút liên hệ nổi --}}
@endsection
