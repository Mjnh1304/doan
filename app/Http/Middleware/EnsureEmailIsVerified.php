<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && !$request->user()->hasVerifiedEmail()) {
            // Nếu chưa xác minh email, redirect về trang verify notice với message
            return redirect()->route('verification.notice')->with('warning', 'Vui lòng xác minh email trước khi tiếp tục.');
        }

        return $next($request);
    }
}