@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Danh sách Villa / Resort Sóc Sơn</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($villas as $villa)
        <div class="bg-white rounded shadow-lg overflow-hidden">
            <a href="{{ route('villas.show', $villa->id) }}">
                <img src="{{ asset('images/' . $villa->image) }}" alt="{{ $villa->name }}" class="w-full h-48 object-cover">
            </a>
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-2">
                    <a href="{{ route('villas.show', $villa->id) }}" class="hover:underline">{{ $villa->name }}</a>
                </h2>
                <p class="text-gray-700 mb-2">{{ Str::limit($villa->description, 100) }}</p>
                <p class="text-indigo-600 font-bold">{{ number_format($villa->price, 0, ',', '.') }} VND/đêm</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection