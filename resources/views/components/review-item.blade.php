<div class="mb-4 border-b pb-4 flex justify-between items-start">
    {{-- Cột trái --}}
    <div class="flex-1">
        {{-- Chỉ hiển thị sao nếu là bình luận cha --}}
        @if ($depth === 0)
        <div class="text-yellow-500 font-bold text-lg mb-1">
            @for ($i = 1; $i <= 5; $i++)
                {{ $i <= $review->rating ? '★' : '☆' }}
                @endfor
                </div>
                @endif

                {{-- Hiển thị tên + nội dung --}}
                <div id="comment-display-{{ $review->id }}">
                    <p class="text-gray-800 font-semibold">{{ $review->user->name ?? 'Ẩn danh' }}</p>
                    <p class="text-gray-600">
                        {{ $review->comment }}
                        @if($review->updated_at->gt($review->created_at))
                        <span class="text-sm text-gray-400 italic">(đã chỉnh sửa)</span>
                        @endif
                    </p>
                </div>

                {{-- Form chỉnh sửa --}}
                <div id="comment-edit-{{ $review->id }}" class="hidden">
                    <input type="hidden" name="reviewable_type" value="{{ get_class($review->reviewable) }}">
                    <input type="hidden" name="reviewable_id" value="{{ $review->reviewable->id }}">

                    @if ($depth === 0)
                    <label class="block text-sm font-medium text-gray-700">Sửa đánh giá:</label>
                    <div class="flex space-x-1 cursor-pointer" id="edit-star-container-{{ $review->id }}">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg onclick="setEditRating({{ $review->id }}, {{ $i }})"
                            onmouseover="highlightEditStars({{ $review->id }}, {{ $i }})"
                            onmouseout="resetEditStars({{ $review->id }})"
                            class="w-6 h-6 text-gray-300"
                            fill="currentColor" viewBox="0 0 20 20" id="edit-star-{{ $review->id }}-{{ $i }}">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.946h4.15c.969 0
                                    1.371 1.24.588 1.81l-3.36 2.443 1.287 3.946c.3.921-.755 1.688-1.54
                                    1.118L10 13.347l-3.361 2.443c-.784.57-1.838-.197-1.539-1.118l1.287-3.946-3.36-2.443c-.784-.57-.38-1.81.588-1.81h4.15l1.286-3.946z" />
                            </svg>
                            @endfor
                    </div>
                    <input type="hidden" id="edit-rating-{{ $review->id }}" value="{{ $review->rating }}">
                    @endif

                    <textarea id="edit-comment-{{ $review->id }}" rows="3" class="w-full border border-gray-300 rounded px-2 py-1">{{ $review->comment }}</textarea>

                    <div class="flex space-x-2 mt-2">
                        <button onclick="submitEdit({{ $review->id }})" class="bg-green-600 text-white px-3 py-1 rounded">Lưu</button>
                        <button onclick="cancelEdit({{ $review->id }})" class="bg-gray-300 px-3 py-1 rounded">Hủy</button>
                    </div>
                </div>

                <p class="text-sm text-gray-400 mt-1">{{ $review->created_at->diffForHumans() }}</p>
        </div>

        {{-- Cột phải: hành động --}}
        <div class="flex flex-col items-end space-y-2 ml-4 text-sm mt-1">
            @if(auth()->check() && auth()->id() === $review->user_id)
            <button onclick="startEdit({{ $review->id }})" class="text-blue-600 hover:underline">Chỉnh sửa</button>
            @endif

            @if(auth()->check() && auth()->user()->role === 'admin')
            <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Xóa bình luận và đánh giá này?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline">Xóa</button>
            </form>
            @endif

            @if(auth()->check())
            <button onclick="toggleReplyForm({{ $review->id }})" class="text-sm text-blue-500 hover:underline mt-2">Trả lời</button>
            <div id="reply-form-{{ $review->id }}" class="hidden mt-2">
                <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="reviewable_type" value="{{ get_class($review->reviewable) }}">
                    <input type="hidden" name="reviewable_id" value="{{ $review->reviewable->id }}">
                    <input type="hidden" name="parent_id" value="{{ $review->id }}">
                    <textarea name="comment" rows="2" class="w-full border rounded px-2 py-1 mb-2" placeholder="Viết trả lời..."></textarea>
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded">Gửi</button>
                    <button type="button" onclick="toggleReplyForm({{ $review->id }})" class="text-gray-500 text-sm ml-2">Huỷ</button>
                </form>
            </div>
            @endif
        </div>
    </div>
    {{-- Bình luận con --}}
    @if (!isset($disableChildren) && $review->children && $review->children->count())
    <div class="ml-4 border-l-2 border-gray-300 pl-4 mt-2 rounded-md"
        style="width: {{ 100 - ($depth * 15) }}%; background-color: rgba(229, 231, 235, 0.3);">
        <button
            onclick="toggleReplies({{ $review->id }}, this)"
            class="text-sm text-blue-600 hover:underline mb-2 block"
            data-count="{{ $review->children->count() }}">
            Xem {{ $review->children->count() }} phản hồi
        </button>
        <div id="replies-{{ $review->id }}" class="hidden space-y-4">
            @foreach($review->children as $childReview)
            <x-review-item :review="$childReview" :depth="$depth + 1" />
            @endforeach
        </div>
    </div>
    @endif

    <script>
        function toggleReplyForm(id) {
            document.getElementById('reply-form-' + id)?.classList.toggle('hidden');
        }

        function toggleReplies(id, btn) {
            const repliesDiv = document.getElementById('replies-' + id);
            if (!repliesDiv) return;

            repliesDiv.classList.toggle('hidden');

            // Đổi text nút theo trạng thái
            const count = btn.getAttribute('data-count');
            if (repliesDiv.classList.contains('hidden')) {
                btn.textContent = `Xem ${count} phản hồi`;
            } else {
                btn.textContent = `Ẩn ${count} phản hồi`;
            }
        }
    </script>