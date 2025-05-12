<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifyNewEmail;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $section = $request->input('section');

        if ($section === 'username') {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
            ]);

            $user->name = $request->name;
            $user->save();

            return redirect()->route('profile.edit')->with('success', 'Tên hiển thị đã được cập nhật.');
        }

        if ($section === 'email') {
            $request->validate([
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            ]);

            if ($request->email !== $user->email) {
                // Lưu email mới vào pending_email
                $user->pending_email = $request->email;
                $user->save();

                // Gửi email xác minh
                \Log::info('Sending verification email for: ' . $request->email);
                Notification::send($user, new VerifyNewEmail($request->email));

                return redirect()->route('profile.edit')->with('success', 'Một email xác minh đã được gửi. Vui lòng xác minh để cập nhật email.');
            }

            return redirect()->route('profile.edit')->with('success', 'Email không thay đổi.');
        }

        return redirect()->route('profile.edit')->withErrors(['section' => 'Yêu cầu không hợp lệ.']);
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}