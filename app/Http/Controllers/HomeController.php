<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Villa;

class HomeController extends Controller
{
    public function index()
    {
        $villas = Villa::all();
        return view('home', compact('villas')); 
    }

    public function show($id)
    {
        $villa = Villa::findOrFail($id);
        return view('villas.show', compact('villa'));
    }
}   