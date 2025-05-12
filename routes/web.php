<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\Admin\VillaController as AdminVillaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\PasswordUpdateController;
use App\Http\Controllers\Auth\VerifyNewEmailController;


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('/villas', AdminVillaController::class)->names([
        'index' => 'villas.index',
        'create' => 'villas.create',
        'store' => 'villas.store',
        'show' => 'villas.show',
        'edit' => 'villas.edit',
        'update' => 'villas.update',
        'destroy' => 'villas.destroy',
    ]);

    Route::resource('/users', UserController::class)->except(['create', 'store', 'show'])->names([
        'index' => 'users.index',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/villas', [HomeController::class, 'index'])->name('villas.index');


Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [PasswordUpdateController::class, 'update'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [PasswordUpdateController::class, 'update'])->name('password.update');
    Route::get('/email/verify/new/{id}/{hash}', [VerifyNewEmailController::class, 'verify'])
        ->middleware(['signed'])
        ->name('email.verify.new');
});

Route::get('lang/switch/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'vi'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

require __DIR__ . '/auth.php';