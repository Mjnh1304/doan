@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@section('content')
<a href="{{ route('resorts.index') }}"
    class="inline-flex items-center text-indigo-700 hover:underline mb-4 text-lg font-semibold">
    ← {{ __('booking.back-to-resort') }}
</a>
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md">
    {{-- Ảnh chính --}}
    <img src="{{ $resort->image ? asset('storage/' . $resort->image) : asset('images/default.jpg') }}"
        alt="{{ $resort->name }}"
        class="w-full h-64 object-cover rounded-lg mb-6">

    {{-- Ảnh 360 --}}
    @if ($resort->panorama_url)
    <div class="mb-6">
        <p class="text-gray-800 font-semibold mb-2">{{ __('villa.360-view') }}:</p>
        <div class="aspect-video w-full">
            <iframe
                src="{{ $resort->panorama_url }}"
                frameborder="0"
                allowfullscreen
                allow="accelerometer; deviceorientation"
                class="w-full h-80 rounded-lg shadow">
            </iframe>
        </div>
    </div>
    @endif

    {{-- Thông tin resort --}}
    <h2 class="text-3xl font-bold mb-4 text-indigo-700">{{ $resort->name }}</h2>
    @if($resort->reviews->count())
    <p class="text-yellow-500 text-sm mb-4">
        ★
        <span class="text-gray-500">{{ number_format($resort->reviews->avg('rating'), 1) }} / 5 ({{ $resort->reviews->count() }} {{ __('booking.rate') }})</span>
    </p>
    @endif
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ __('villa.amenities') }}:</h3>
        <p class="text-gray-600 whitespace-pre-line leading-relaxed">
            {!! nl2br(e($resort->description)) !!}
        </p>
    </div>

    <p class="text-indigo-600 font-bold text-xl mb-6">
        {{ __('resort.price_unit', ['price' => number_format($resort->price ?? 0, 0, ',', '.')]) }}
    </p>

    {{-- Form đặt lịch --}}
    <div class="flex justify-center">
        <div class="w-full md:w-2/3 lg:w-1/2">
            <form action="{{ route('bookings.store') }}" method="POST"
                class="booking-form p-6 bg-white border border-gray-200 rounded-2xl shadow space-y-5">
                @csrf
                <input type="hidden" name="bookable_id" value="{{ $resort->id }}">
                <input type="hidden" name="bookable_type" value="App\Models\Resort">

                <h3 class="text-xl font-semibold text-center text-gray-800">{{ __('booking.title') }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="checkin" class="block text-sm font-medium text-gray-700 mb-1">{{ __('booking.check-in') }}</label>
                        <input type="text" name="check_in" id="checkin" required
                            class="flatpickr block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                    </div>
                    <div>
                        <label for="checkout" class="block text-sm font-medium text-gray-700 mb-1">{{ __('booking.check-out') }}</label>
                        <input type="text" name="check_out" id="checkout" required
                            class="flatpickr block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                    </div>
                </div>

                <div>
                    <label for="guests" class="block text-sm font-medium text-gray-700 mb-1">{{ __('booking.guests') }}</label>
                    <input type="number" name="guests" id="guests" min="1" required
                        class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">{{ __('booking.notes') }}</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="block w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                        placeholder="Ghi chú thêm (nếu có)..."></textarea>
                </div>

                <div class="ajax-message text-sm text-red-600"></div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 shadow">
                    {{ __('booking.submit') }}
                </button>
            </form>
        </div>
    </div>
    {{-- Đánh giá & bình luận --}}
    <div class="mt-10">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">{{ __('review.leave') }}</h3>

        {{-- Form gửi đánh giá --}}
        @auth
        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4 mb-6">
            @csrf
            <input type="hidden" name="reviewable_id" value="{{ $resort->id }}">
            <input type="hidden" name="reviewable_type" value="App\Models\Resort">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('review.choose') }}:</label>
                <div class="flex space-x-1" id="star-container">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg onclick="setRating({{ $i }})"
                        onmouseover="highlightStars({{ $i }})"
                        onmouseout="resetStars()"
                        class="w-8 h-8 cursor-pointer text-gray-300"
                        fill="currentColor" viewBox="0 0 20 20" id="star-{{ $i }}">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.946h4.15c.969 0 
                    1.371 1.24.588 1.81l-3.36 2.443 1.287 3.946c.3.921-.755 1.688-1.54 
                    1.118L10 13.347l-3.361 2.443c-.784.57-1.838-.197-1.539-1.118l1.287-3.946-3.36-2.443c-.784-.57-.38-1.81.588-1.81h4.15l1.286-3.946z" />
                        </svg>
                        @endfor
                </div>
                <input type="hidden" name="rating" id="rating" value="5">
            </div>
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">{{ __('review.comment') }}:</label>
                <textarea name="comment" id="comment" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2"></textarea>
            </div>
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                {{ __('review.submit') }}
            </button>
        </form>
        @else
        <p class="text-gray-600">{{ __('review.login-to-review') }} <a href="{{ route('login') }}" class="text-indigo-600 underline">{{ __('review.login') }}</a>  {{ __('review.to-leave-review') }}.</p>
        @endauth

        <h3 class="text-2xl font-semibold text-gray-800 mb-4 text-center">{{ __('review.list') }}</h3>
        <div id="reviews-list">
            @foreach($reviews as $review)
            <x-review-item :review="$review" :depth="0" />
            @endforeach
        </div>

        @if ($resort->reviews()->whereNull('parent_id')->count() > 5)
    <div class="text-center mt-4">
        <button onclick="loadMoreReviews({{$resort->id}})"
            class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded"
            id="load-more-btn">
            {{ __('review.load-more') }}
        </button>
    </div>
@endif
        @include('layouts.partials.contact-floating') {{-- Nút liên hệ nổi --}}
        @endsection



        @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        @endpush

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const bookedDatesObj = @json($bookedDates[$resort -> id] ?? []);
                    const bookedDates = Object.values(bookedDatesObj);
                    console.log('Booked Dates:', bookedDates);

                    const form = document.querySelector('.booking-form');
                    const checkInInput = form.querySelector('input[name="check_in"]');
                    const checkOutInput = form.querySelector('input[name="check_out"]');
                    const messageBox = form.querySelector('.ajax-message');

                    if (!form || !checkInInput || !checkOutInput || !messageBox) {
                        console.error('Form elements missing:', {
                            form,
                            checkInInput,
                            checkOutInput,
                            messageBox
                        });
                        messageBox.innerHTML = `
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                    Lỗi: Không tìm thấy các thành phần form. Vui lòng liên hệ hỗ trợ.
                </div>`;
                        return;
                    }

                    const currentLocale = '{{ app()->getLocale() }}';

                    flatpickr(checkInInput, {
                        locale: currentLocale === 'vi' ? flatpickr.l10ns.vn : flatpickr.l10ns.default,
                        dateFormat: 'Y-m-d',
                        minDate: 'today',
                        disable: bookedDates,
                        onChange: function(selectedDates, dateStr) {
                            if (checkOutInput._flatpickr) {
                                const minCheckOutDate = new Date(dateStr);
                                minCheckOutDate.setDate(minCheckOutDate.getDate() + 1);
                                console.log('minCheckOutDate set to:', minCheckOutDate);
                                checkOutInput._flatpickr.set('minDate', minCheckOutDate);
                                if (checkOutInput.value) {
                                    const checkOutDate = new Date(checkOutInput.value);
                                    if (checkOutDate < minCheckOutDate) {
                                        checkOutInput._flatpickr.clear();
                                    }
                                }
                            }
                        }
                    });

                    flatpickr(checkOutInput, {
                        locale: currentLocale === 'vi' ? flatpickr.l10ns.vn : flatpickr.l10ns.default,
                        dateFormat: 'Y-m-d',
                        minDate: 'tomorrow',
                        disable: bookedDates
                    });

                    form.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        messageBox.innerHTML = '';

                        const checkInDate = new Date(checkInInput.value);
                        const checkOutDate = new Date(checkOutInput.value);
                        checkInDate.setHours(0, 0, 0, 0);
                        checkOutDate.setHours(0, 0, 0, 0);

                        console.log('checkInDate:', checkInDate);
                        console.log('checkOutDate:', checkOutDate);

                        if (!checkInInput.value || !checkOutInput.value) {
                            messageBox.innerHTML = `
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                        Vui lòng chọn cả ngày check-in và check-out.
                    </div>`;
                            return;
                        }

                        const minCheckOutDate = new Date(checkInDate);
                        minCheckOutDate.setDate(minCheckOutDate.getDate() + 1);
                        minCheckOutDate.setHours(0, 0, 0, 0);
                        console.log('minCheckOutDate:', minCheckOutDate);

                        if (checkOutDate < minCheckOutDate) {
                            messageBox.innerHTML = `
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                        Ngày check-out phải sau ngày check-in ít nhất 1 ngày.
                    </div>`;
                            return;
                        }

                        const formData = new FormData(form);
                        const url = form.getAttribute('action');

                        try {
                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                    'Accept': 'application/json'
                                },
                                body: formData
                            });

                            const data = await response.json();

                            if (response.ok) {
                                messageBox.innerHTML = `
                        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                            ${data.message || 'Đặt lịch thành công!'}
                        </div>`;
                                form.reset();
                            } else if (response.status === 401) {
                                messageBox.innerHTML = `
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                    Vui lòng đăng nhập để tiếp tục.
                </div>`;
                            } else {
                                const errors = data.errors ?
                                    Object.values(data.errors).flat().map(e => `<li>${e}</li>`).join('') :
                                    `<li>${data.message || 'Đã xảy ra lỗi!'}</li>`;
                                messageBox.innerHTML = `
                        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                            <ul class="list-disc list-inside">${errors}</ul>
                        </div>`;
                            }
                        } catch (err) {
                            console.error('Error:', err);
                            messageBox.innerHTML = `
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                        Lỗi kết nối, vui lòng thử lại.
                    </div>`;
                        }
                    });
                } catch (error) {
                    console.error('Error in script:', error);
                    messageBox.innerHTML = `
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                Lỗi khởi tạo lịch đặt phòng. Vui lòng tải lại trang hoặc liên hệ hỗ trợ.
            </div>`;
                }
            });

            let selectedRating = 0;

            function setRating(rating) {
                selectedRating = rating;
                document.getElementById('rating').value = rating;
                highlightStars(rating);
            }

            function highlightStars(rating) {
                for (let i = 1; i <= 5; i++) {
                    const star = document.getElementById('star-' + i);
                    if (i <= rating) {
                        star.classList.add('text-yellow-400');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                }
            }

            function resetStars() {
                highlightStars(selectedRating);
            }

            function startEdit(id) {
                document.getElementById('comment-display-' + id).classList.add('hidden');
                document.getElementById('comment-edit-' + id).classList.remove('hidden');

                const ratingInput = document.getElementById('edit-rating-' + id);
                if (ratingInput) {
                    const currentRating = parseInt(ratingInput.value);
                    selectedEditRatings[id] = currentRating;
                    highlightEditStars(id, currentRating);
                }
            }

            function cancelEdit(id) {
                document.getElementById('comment-edit-' + id).classList.add('hidden');
                document.getElementById('comment-display-' + id).classList.remove('hidden');
            }

            function submitEdit(id) {
                    const ratingInput = document.getElementById('edit-rating-' + id);
                    const rating = ratingInput ? ratingInput.value : null;
                    const comment = document.getElementById('edit-comment-' + id).value;
                    const token = '{{ csrf_token() }}';

                    const body = {
                        comment: comment
                    };
                    if (ratingInput) {
                        body.rating = rating;
                    }

                    fetch('{{ url('/reviews') }}/' + id, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(body),
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(data => Promise.reject(data));
                            }
                            return response.json();
                        })
                        .then(data => {
                            const displayDiv = document.getElementById('comment-display-' + id);
                            if (data.user_name) {
                               displayDiv.innerHTML = `<p class="text-gray-800 font-semibold">${data.user_name}</p>
        <p class="text-gray-600">${data.comment} <span class="text-sm text-gray-500">(${data.updated_at_diff})</span>(đã chỉnh sửa)</p>`;
}

                            // Cập nhật sao nếu là bình luận cha
                            const ratingContainer = displayDiv.previousElementSibling;
                            if (data.rating !== null && ratingContainer) {
                                let stars = '';
                                for (let i = 1; i <= 5; i++) {
                                    stars += i <= data.rating ? '★' : '☆';
                                }
                                ratingContainer.innerHTML = stars;
                            }

                            cancelEdit(id);
                        })
                        .catch(error => {
                            alert('Có lỗi xảy ra khi cập nhật. Vui lòng thử lại.');
                            console.error(error);
                        });
                }
            let selectedEditRatings = {}; // Lưu rating tạm cho mỗi review đang chỉnh sửa

            function setEditRating(id, rating) {
                selectedEditRatings[id] = rating;
                document.getElementById('edit-rating-' + id).value = rating;
                highlightEditStars(id, rating);
            }

            function highlightEditStars(id, rating) {
                for (let i = 1; i <= 5; i++) {
                    const star = document.getElementById('edit-star-' + id + '-' + i);
                    if (i <= rating) {
                        star.classList.add('text-yellow-400');
                        star.classList.remove('text-gray-300');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                }
            }

            function resetEditStars(id) {
                highlightEditStars(id, selectedEditRatings[id] || 0);
            }

            document.addEventListener('DOMContentLoaded', function() {
                setRating(5); // Gọi hàm để hiển thị và set mặc định 5 sao
            });

            let reviewOffset = 5;

            function loadMoreReviews(resortId) {
                fetch(`/resorts/${resortId}/reviews/load?offset=${reviewOffset}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.html.trim() === '') {
                            document.getElementById('load-more-btn')?.remove();
                        } else {
                            document.getElementById('reviews-list').insertAdjacentHTML('beforeend', data.html);
                            reviewOffset += 5;
                        }
                    });
            }
        </script>
        @endpush