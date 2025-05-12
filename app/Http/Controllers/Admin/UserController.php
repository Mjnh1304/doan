<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Lọc theo search (tên hoặc email)
        if ($search = $request->query('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        // Lọc theo vai trò
        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }

        // Phân trang, 10 người dùng mỗi trang
        $users = $query->paginate(10);

        // Thêm query string vào liên kết phân trang
        $users->appends($request->query());

        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Không thể xoá admin.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Xoá người dùng thành công.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Cập nhật vai trò thành công.');
    }
}
