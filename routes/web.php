<?php

use App\Http\Controllers\configurationController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [dashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->prefix('configuration')->group(function () {
    Route::get('/league-and-cup', [configurationController::class, 'leagueAndCup'])->name('config.league');
    Route::post('/league-and-cup', [configurationController::class, 'saveLeagueAndCup']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
