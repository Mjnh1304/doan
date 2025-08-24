<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
            'reviewable_id' => 'required|integer',
            'reviewable_type' => 'required|string',
            'parent_id' => 'nullable|exists:reviews,id',
        ]);

        // Bản đồ model (nếu có nhiều loại như villa/resort)
        $classMap = [
            'villa' => \App\Models\Villa::class,
            'resort' => \App\Models\Resort::class,
        ];

        // Tên loại không phân biệt hoa thường (ví dụ villa/ViLLA/Villa)
        $typeKey = strtolower(class_basename($request->reviewable_type));

        if (!isset($classMap[$typeKey])) {
            return back()->withErrors(['reviewable_type' => 'Loại đánh giá không hợp lệ.']);
        }

        $modelClass = $classMap[$typeKey];

        // Tìm đối tượng đánh giá (Villa hoặc Resort)
        $item = $modelClass::findOrFail($request->reviewable_id);

        // Tạo mới bình luận (cha hoặc con)
        $data = [
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'parent_id' => $request->parent_id,
        ];

        // Nếu là trả lời (bình luận con)
        if ($request->filled('parent_id')) {
            $data['parent_id'] = $request->parent_id;
        } else {
            // Nếu là bình luận cha thì có thêm rating
            $data['rating'] = $request->rating;
        }

        $item->reviews()->create($data);

        return back()->with('success', 'Đánh giá và bình luận đã được gửi!');
    }


    public function update(Request $request, Review $review)
    {
        // Chỉ chủ bình luận mới được sửa
        if (auth()->id() !== $review->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        $review->load('user');
        // Trả về JSON dữ liệu mới để JS cập nhật
        return response()->json([
            'comment' => $review->comment,
            'rating' => $review->rating,
            'user_name' => $review->user->name,
            'updated_at_diff' => $review->updated_at->diffForHumans(),
        ]);
    }

    public function destroy(Review $review)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $review->delete();

        return back()->with('success', 'Bình luận đã được xoá.');
    }
    public function loadMoreReviews(Request $request, \App\Models\Villa $villa)
    {
        $offset = (int) $request->query('offset', 0);
        $limit = 5;

        $reviews = $villa->reviews()
            ->with(['user'])
            ->whereNull('parent_id')
            ->orderByDesc('created_at')
            ->skip($offset)
            ->take($limit)
            ->get();

        $html = '';
        foreach ($reviews as $review) {
            $html .= view('components.review-item', [
                'review' => $review,
                'depth' => 0,
                'disableChildren' => true,
            ])->render();
        }

        $total = $villa->reviews()->whereNull('parent_id')->count();
        $loaded = $offset + $reviews->count();

        return response()->json([
            'html' => $html,
            'total' => $total,
            'loaded' => $loaded,
        ]);
    }
}
