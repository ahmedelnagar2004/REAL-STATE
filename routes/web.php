<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Frontend\pookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('unites', UniteController::class);
Route::delete('images/{id}', [UniteController::class, 'deleteImage'])->name('images.delete');
Route::post('unites/{unite}/images', [UniteController::class, 'addImages'])->name('unites.addImages');

Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');
Route::get('/search', [FrontendController::class, 'search'])->name('frontend.search');
Route::get('/units/{unite}', [FrontendController::class, 'show'])->name('frontend.units.show');
    // المسارات الموجودة حالياً
    // ...
// إضافة راوت حفظ الحجز
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
// إضافة راوت حفظ الحجز
Route::post('/frontend/bookings', [App\Http\Controllers\Frontend\BookingController::class, 'store'])
    ->name('frontend.bookings.store');
// مسارات الحجوزات
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}/details', [AdminBookingController::class, 'details'])->name('bookings.details');
    Route::post('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
});

require __DIR__.'/auth.php';
