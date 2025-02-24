<?php

use App\Http\Controllers\OrdenadorController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::resource('ordenadores', OrdenadorController::class)->parameters(['ordenadores' => 'ordenador']);
Route::post('ordenadores/{ordenador}/cambiar', [OrdenadorController::class, 'cambiar'])->name('ordenadores.cambiar');


require __DIR__.'/auth.php';
