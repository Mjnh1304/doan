<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Villa;
use Illuminate\Support\Facades\Storage;

class VillaController extends Controller
{
     public function index(Request $request)
    {
        $query = Villa::query();

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

        $villas = $query->paginate(10)->withQueryString();

        return view('admin.villas.index', compact('villas'));
    }

    public function create()
    {
        return view('admin.villas.create');
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
            $imagePath = $request->file('image')->store('villas', 'public');
            $data['image'] = $imagePath;
        }

        Villa::create($data);

        return redirect()->route('admin.villas.index')->with('success', 'Thêm villa thành công!');
    }

    public function edit($id)
    {
        $villa = Villa::findOrFail($id);
        return view('admin.villas.edit', compact('villa'));
    }

    public function update(Request $request, $id)
    {
        $villa = Villa::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'panorama_url' => 'nullable|url',
        ]);

        $data = $request->only('name', 'location', 'price', 'description','panorama_url');

        if ($request->hasFile('image')) {
            if ($villa->image && Storage::disk('public')->exists($villa->image)) {
                Storage::disk('public')->delete($villa->image);
            }

            $imagePath = $request->file('image')->store('villas', 'public');
            $data['image'] = $imagePath;
        }

        $villa->update($data);

        return redirect()->route('admin.villas.index')->with('success', 'Cập nhật villa thành công!');
    }

    public function destroy($id)
    {
        $villa = Villa::findOrFail($id);

        // Xóa ảnh trong storage nếu có
        if ($villa->image && Storage::disk('public')->exists($villa->image)) {
            Storage::disk('public')->delete($villa->image);
        }

        $villa->delete();

        return redirect()->route('admin.villas.index')->with('success', 'Xóa villa thành công!');
    }
}
