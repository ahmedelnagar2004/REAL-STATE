<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Frontend\pookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\Admin\ClientController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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


    // راوتات الحجوزات
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

Route::prefix('market')->group(function () {
    Route::get('/', [MarketController::class, 'index'])->name('frontend.market');
    Route::get('/create', [MarketController::class, 'create'])->name('frontend.market.create');
    Route::post('/store', [MarketController::class, 'store'])->name('frontend.market.store');
    Route::get('/{id}', [MarketController::class, 'show'])->name('frontend.market.show');
    Route::get('/{id}/edit', [MarketController::class, 'edit'])->name('frontend.market.edit');
    Route::put('/{id}', [MarketController::class, 'update'])->name('frontend.market.update');
    Route::delete('/{id}', [MarketController::class, 'destroy'])->name('frontend.market.destroy');
});


    Route::get('/clients', [ClientController::class, 'index'])->name('admin.clients.index');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('admin.clients.show');
    Route::post('/clients/{id}/status', [ClientController::class, 'updateStatus'])->name('admin.clients.status');

Route::post('/admin/clients/{id}/status', [ClientController::class, 'updateStatus'])
    ->name('admin.clients.status')
    ->middleware('web');

require __DIR__.'/auth.php';
