<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UniteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontendController;


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

require __DIR__.'/auth.php';
