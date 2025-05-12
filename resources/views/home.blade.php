@extends('layouts.app')

@section('content')
    @if ($villas->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($villas as $villa)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <button onclick="openModal({{ $villa->id }})" class="w-full text-left">
                        <img src="{{ $villa->image ? asset('storage/' . $villa->image) : asset('images/default.jpg') }}"
                             alt="{{ $villa->name ?: 'Tên villa không xác định' }}"
                             class="w-full h-52 object-cover hover:scale-105 transition-transform duration-300">
                    </button>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-indigo-700 truncate">
                            {{ $villa->name ?: 'Tên villa không xác định' }}
                        </h3>
                        <p class="text-gray-600 text-sm mt-2">
                            {{ \Str::limit($villa->description ?: 'Không có mô tả', 100) }}
                        </p>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-indigo-600 font-bold text-base">
                                {{ number_format($villa->price ?? 0, 0, ',', '.') }} VND / người
                            </span>
                            <button onclick="openModal({{ $villa->id }})"
                                    class="bg-indigo-600 text-white text-sm px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition">
                                Xem chi tiết
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modal --}}
<div id="modal-{{ $villa->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl w-full max-w-2xl p-6 relative shadow-lg">
        <button onclick="closeModal({{ $villa->id }})"
                class="absolute top-3 right-3 text-gray-500 hover:text-black text-xl">&times;</button>

        {{-- Ảnh chính --}}
        <img src="{{ $villa->image ? asset('storage/' . $villa->image) : asset('images/default.jpg') }}"
             alt="{{ $villa->name }}"
             class="w-full h-64 object-cover rounded-lg mb-4">

        {{-- Ảnh 360 --}}
        <div class="mb-4">
            <p class="text-gray-800 font-semibold mb-2">Ảnh 360 của căn:</p>
            <div class="aspect-video w-full">
                <iframe 
                    src="https://momento360.com/e/u/f0d147c5aa404d22b411f27a0afd5a95?utm_campaign=embed&utm_source=other&heading=-274.61&pitch=6.3&field-of-view=75&size=medium&display-plan=true" 
                    frameborder="0" 
                    allowfullscreen 
                    class="w-full h-80 rounded-lg shadow">
                </iframe>
            </div>
        </div>

        {{-- Thông tin villa --}}
        <h2 class="text-2xl font-bold mb-2">{{ $villa->name }}</h2>
        <p class="text-gray-700 mb-4">Tiện ích: {{ $villa->description }}</p>
        <p class="text-indigo-600 font-semibold">Giá thuê: {{ number_format($villa->price, 0, ',', '.') }} VND/người</p>
    </div>
</div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 text-lg mt-12">Không có villa nào để hiển thị.</p>
    @endif

    {{-- JavaScript để điều khiển modal --}}
    <script>
        function openModal(id) {
            document.getElementById(`modal-${id}`).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(`modal-${id}`).classList.add('hidden');
        }
    </script>
@endsection