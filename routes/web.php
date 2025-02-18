<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthProviderController;

Route::get('/', function () {
    return view('mechanical.home-page');
})->name('home');

Route::middleware('web')->get('/google', [AuthProviderController::class, 'googleAuth'])->name('google');
Route::middleware('web')->get('/google/callback', [AuthProviderController::class, 'googleCallback']);

Route::view('login', 'mechanical.auth.login')->name('login')->middleware('guest');
Route::view('register', 'mechanical.auth.register')->name('register')->middleware('guest');

Route::view('/esquecer-senha', 'mechanical.auth.forgot-password')->name('forgot-password')->middleware('guest');
Route::view('/reset-password/{token}', 'mechanical.auth.reset-password')->name('password.reset')->middleware('guest');

//Route::domain('{account}.'.env('APP_URL'))->middleware([\App\Http\Middleware\SubdomainAuth::class, 'auth', 'verified'])->group(function () {
//    Route::view('/dashboard','mechanical.dashboard')->name('dashboard');
//});

Route::get('/dashboard', function () {
    return view('mechanical.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::domain('{account}.'.env('APP_URL'))->middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::view('/tenant-register', 'mechanical.auth.tenant-register')->name('tenant.register');
//});

Route::view('usuario', 'mechanical.auth.register-user')->name('user.index');

// require __DIR__.'/auth.php';
