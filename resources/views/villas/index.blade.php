@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();

            fetch("{{ route('villas.index') }}?" + params, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('#villa-list');
                document.querySelector('#villa-list').innerHTML = newContent.innerHTML;
            })
            .catch(err => console.error('Lỗi khi tải filter:', err));
        });
    });
</script>
@endpush

@section('search')
<form method="GET" action="{{ route('villas.index') }}" class="mb-6 bg-white p-4 rounded-xl shadow flex flex-col sm:flex-row sm:items-end sm:space-x-4 space-y-4 sm:space-y-0">
    <div class="flex-1">
        <label for="search" class="block text-sm font-medium text-gray-700">{{ __('villa.search_label') }}</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>

    <div>
        <label for="min_price" class="block text-sm font-medium text-gray-700">{{ __('villa.min_price') }}</label>
        <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>

    <div>
        <label for="max_price" class="block text-sm font-medium text-gray-700">{{ __('villa.max_price') }}</label>
        <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>

    <div>
        <label for="min_rating" class="block text-sm font-medium text-gray-700">{{ __('villa.min_rating') }}</label>
        <select name="min_rating" id="min_rating"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="">{{ __('villa.all_ratings') }}</option>
            @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ request('min_rating') == $i ? 'selected' : '' }}>
                    {{ __('villa.from_stars', ['stars' => $i]) }}
                </option>
            @endfor
        </select>
    </div>

    <div>
        <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
            {{ __('villa.filter') }}
        </button>
    </div>
</form>
@endsection

@section('content')
<div id="villa-list">
@if ($villas->isNotEmpty())
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach ($villas as $villa)
    <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
        <a href="{{ route('villas.show', $villa->id) }}" class="w-full block">
            <img src="{{ $villa->image ? asset('storage/' . $villa->image) : asset('images/default.jpg') }}"
                alt="{{ $villa->name ?: __('villa.unknown_name') }}"
                class="w-full h-52 object-cover hover:scale-105 transition-transform duration-300">
        </a>
        <div class="p-4">
            <h3 class="text-lg font-semibold text-indigo-700 truncate">
                {{ $villa->name ?: __('villa.unknown_name') }}
            </h3>
            <p class="text-gray-600 text-sm mt-2">
                {{ \Str::limit($villa->description ?: __('villa.no_description'), 100) }}
            </p>
            <div class="mt-3 flex justify-between items-center">
                <span class="text-indigo-600 font-bold text-base">
                    {{ __('villa.price_unit', ['price' => number_format($villa->price ?? 0, 0, ',', '.')]) }}
                </span>
                <a href="{{ route('villas.show', $villa->id) }}"
                    class="bg-indigo-600 text-white text-sm px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition">
                   {{ __('villa.view_detail') }}
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p class="text-center text-gray-500 text-lg mt-12">{{ __('villa.no_results') }}</p>
@endif
</div>
@include('layouts.partials.contact-floating') {{-- Nút liên hệ nổi --}}
@endsection
