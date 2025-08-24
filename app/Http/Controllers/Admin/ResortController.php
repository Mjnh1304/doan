<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resort;
use Illuminate\Support\Facades\Storage;

class ResortController extends Controller
{
    public function index(Request $request)
    {
        $query = Resort::query();

        // Tìm kiếm
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%")
                    ->orWhere('location', 'like', "%$keyword%");
            });
        }

        // Sắp xếp
        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $resorts = $query->paginate(10)->withQueryString();

        return view('admin.resorts.index', compact('resorts'));
    }

    public function create()
    {
        return view('admin.resorts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'panorama_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only('name', 'location', 'price', 'description', 'panorama_url');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('resorts', 'public');
            $data['image'] = $imagePath;
        }

        resort::create($data);

        return redirect()->route('admin.resorts.index')->with('success', 'Thêm resort thành công!');
    }

    public function edit($id)
    {
        $resort = resort::findOrFail($id);
        return view('admin.resorts.edit', compact('resort'));
    }

    public function update(Request $request, $id)
    {
        $resort = resort::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'panorama_url' => 'nullable|url',
        ]);

        $data = $request->only('name', 'location', 'price', 'description', 'panorama_url');

        if ($request->hasFile('image')) {
            if ($resort->image && Storage::disk('public')->exists($resort->image)) {
                Storage::disk('public')->delete($resort->image);
            }

            $imagePath = $request->file('image')->store('resorts', 'public');
            $data['image'] = $imagePath;
        }

        $resort->update($data);

        return redirect()->route('admin.resorts.index')->with('success', 'Cập nhật resort thành công!');
    }

    public function destroy($id)
    {
        $resort = resort::findOrFail($id);

        // Xóa ảnh trong storage nếu có
        if ($resort->image && Storage::disk('public')->exists($resort->image)) {
            Storage::disk('public')->delete($resort->image);
        }

        $resort->delete();

        return redirect()->route('admin.resorts.index')->with('success', 'Xóa resort thành công!');
    }
}
