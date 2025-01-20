<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/roles', \App\Http\Livewire\Roles::class)->name('roles.index');
    Route::get('/permissions', \App\Http\Livewire\Permissions::class)->name('permissions.index');
});

