<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\VillaController as AdminVillaController;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\PasswordUpdateController;
use App\Http\Controllers\Auth\VerifyNewEmailController;
use App\Http\Middleware\SetLocale;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ResortController;
use App\Http\Controllers\Admin\ResortController as AdminResortController;

// Public routes + locale middleware
Route::middleware(['web', SetLocale::class])->group(function () {

    // Trang chủ: hiển thị trang home.blade.php
    Route::get('/', fn() => view('home'))->name('home');

    // Trang danh sách villa
    Route::get('/villas', [VillaController::class, 'index'])->name('villas.index');
    Route::get('/villas/{id}', [VillaController::class, 'show'])->name('villas.show');

    // Trang danh sách resort
    Route::get('/resorts', [ResortController::class, 'index'])->name('resorts.index');
    Route::get('/resorts/{id}', [ResortController::class, 'show'])->name('resorts.show');

    // Trang danh sách homestay
    Route::get('/homestays', fn() => view('coming-soon'))->name('homestays.index');


    // Trang danh sách flight
    Route::get('/flights', fn() => view('coming-soon'))->name('flights.index');


    // Authenticated routes
    Route::middleware(['auth'])->group(function () {

        // Email verification routes
        Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');

        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return redirect()->route('home');
        })->middleware(['signed'])->name('verification.verify');

        Route::post('/email/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('status', 'verification-link-sent');
        })->middleware(['throttle:6,1'])->name('verification.send');

        Route::get('/email/verify/new/{id}/{hash}', [VerifyNewEmailController::class, 'verify'])
            ->middleware(['signed'])
            ->name('email.verify.new');

        // Routes for verified users
        Route::middleware(['verified'])->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

            Route::put('/password', [PasswordUpdateController::class, 'update'])->name('password.update');
            Route::get('/contact', fn() => view('contact'))->name('contact');
            // Booking creation for authenticated users
            // Tạo mới booking
            Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

            // Lịch sử đặt
            Route::get('/lich-su-dat-lich', [BookingController::class, 'history'])->name('bookings.history');

            // Chi tiết booking
            Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');

            // Hủy booking
            Route::delete('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

            // Hiển thị form thanh toán
            Route::get('/bookings/{id}/pay', [BookingController::class, 'showPaymentForm'])->name('bookings.pay.form');

            // Xử lý thanh toán (POST)
            Route::post('/bookings/{id}/pay', [BookingController::class, 'processPayment'])->name('bookings.pay.submit');

            // Hiển thị QR code
            Route::get('/bookings/{id}/qr', [BookingController::class, 'showQrCode'])->name('bookings.qr');

            // Kiểm tra thanh toán
            Route::get('/bookings/{id}/check-payment', [BookingController::class, 'checkPaymentStatus'])->name('bookings.checkPayment');

            // (Nếu cần POST QR, bạn nên đặt tên rõ hơn)
            Route::post('/bookings/{id}/qr', [BookingController::class, 'handleQrConfirmation'])->name('bookings.qr.confirm');
        });
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::put('/reviews/{id}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
        Route::get('/villas/{villa}/reviews/load', [ReviewController::class, 'loadMoreReviews'])->name('reviews.loadMore');
        Route::get('/resorts/{resort}/reviews/load', [ReviewController::class, 'loadMoreReviews'])->name('reviews.loadMore');
    });

    // Language switch
    Route::get('lang/switch/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'vi'])) {
            session(['locale' => $locale]);
            session()->save();
            \Illuminate\Support\Facades\App::setLocale($locale);
        }
        return redirect()->back();
    })->name('lang.switch');

    // Include auth routes (login, register, etc)
    require __DIR__ . '/auth.php';
});

// Admin routes with middleware and prefix
Route::middleware(['web', 'auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('villas', AdminVillaController::class)->names([
        'index' => 'villas.index',
        'create' => 'villas.create',
        'store' => 'villas.store',
        'show' => 'villas.show',
        'edit' => 'villas.edit',
        'update' => 'villas.update',
        'destroy' => 'villas.destroy',
    ]);

     Route::resource('resorts', AdminResortController::class)->names([
        'index' => 'resorts.index',
        'create' => 'resorts.create',
        'store' => 'resorts.store',
        'show' => 'resorts.show',
        'edit' => 'resorts.edit',
        'update' => 'resorts.update',
        'destroy' => 'resorts.destroy',
    ]);

    Route::resource('users', UserController::class)->except(['create', 'store', 'show'])->names([
        'index' => 'users.index',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);

    Route::resource('bookings', AdminBookingController::class)->names([
        'index' => 'bookings.index',
        'create' => 'bookings.create',
        'store' => 'bookings.store',
        'show' => 'bookings.show',
        'edit' => 'bookings.edit',
        'update' => 'bookings.update',
        'destroy' => 'bookings.destroy',
    ]);
});
