<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthProvidersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('mechanical.home-page');
})->name('home');

Route::get('/dashboard', function () {
    return view('mechanical.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('login', 'mechanical.auth.login')->name('login');
Route::view('register', 'mechanical.auth.register')->name('register');

Route::middleware('web')->get('/google', [AuthProvidersController::class, 'googleAuth'])->name('google');
Route::middleware('web')->get('/google/callback', [AuthProvidersController::class, 'googleCallback']);

//Route::domain('{account}.'.env('APP_URL'))->middleware([\App\Http\Middleware\SubdomainAuth::class, 'auth', 'verified'])->group(function () {
//    Route::view('/dashboard','mechanical.dashboard')->name('dashboard');
//});

Route::domain('{account}.'.env('APP_URL'))->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view('/tenant-register', 'mechanical.auth.tenant-register')->name('tenant.register');
});

Route::view('usuario', 'mechanical.auth.register-user')->name('user.index');

// require __DIR__.'/auth.php';
