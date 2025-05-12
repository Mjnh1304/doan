<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyNewEmailController extends Controller
{
    public function verify(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->id);

        if (!hash_equals((string) $request->hash, sha1($request->email))) {
            return redirect('/')->withErrors(['email' => 'Link xác minh không hợp lệ.']);
        }

        if ($user->pending_email !== $request->email) {
            return redirect('/')->withErrors(['email' => 'Email xác minh không khớp.']);
        }

        // Cập nhật email chính thức
        $user->email = $user->pending_email;
        $user->pending_email = null;
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Email đã được xác minh và cập nhật.');
    }
}