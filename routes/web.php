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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'mechanical.dashboard')->name('dashboard');
    Route::view('usuario', 'mechanical.auth.register-user')->name('users');
    Route::view('tenants', 'mechanical.tenants.tenants')->name('tenants');
    Route::view('permissoes', 'mechanical.roles')->name('roles');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::view('inventory', 'mechanical.inventory-management')->name('inventory.index');
    Route::view('inventory/batches', 'mechanical.inventory-management')->name('inventory.batches');
    Route::view('inventory/edit/{product}', 'mechanical.inventory-management')->name('inventory.edit');

// Gerenciamento de Orçamentos
    Route::view('quotes', 'mechanical.quote-management')->name('quotes.index');
    Route::view('quotes/create', 'mechanical.quote-management')->name('quotes.create');
    Route::view('quotes/{quote}', 'mechanical.quote-management')->name('quotes.show');

// Mensagens
    Route::view('messages', 'mechanical.messaging')->name('messages.index');

// Localizador (Mapas)
    Route::view('locations', 'mechanical.location-finder')->name('locations.index');

// Relatórios
    Route::view('reports', 'mechanical.reporting')->name('reports.index');

// Agendamentos
    Route::view('appointments', 'mechanical.appointment-management')->name('appointments.index');
    Route::view('appointments/create', 'mechanical.appointment-management')->name('appointments.create');
    Route::view('appointments/{appointment}', 'mechanical.appointment-management')->name('appointments.show');

});
