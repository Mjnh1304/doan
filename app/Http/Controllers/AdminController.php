<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Villa;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
{
    $villaCount = Villa::count();
    $userCount = User::where('role', 'user')->count();

    return view('admin.dashboard', compact('villaCount', 'userCount'));
}
}