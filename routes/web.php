<?php

use App\Http\Controllers\configurationController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\leagueController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [dashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
Route::get('/start', [dashboardController::class, 'start'])->middleware(['auth'])->name('start');

Route::middleware('auth')->prefix('configuration')->group(function () {
    Route::get('/league-and-cup', [configurationController::class, 'leagueAndCup'])->name('config.league');
    Route::post('/league-and-cup', [configurationController::class, 'saveLeagueAndCup']);
    Route::get('/division', [configurationController::class, 'division'])->name('config.division');
    Route::post('/division', [configurationController::class, 'saveDivision']);
    Route::put('/division/{id}', [configurationController::class, 'modifyDivision'])->name('config.division.modify');
    Route::delete('/division/{id}', [configurationController::class, 'deleteDivision'])->name('config.division.delete');
    Route::get('/teams', [configurationController::class, 'teams'])->name('config.teams');
    Route::post('/teams', [configurationController::class, 'saveTeams']);
    Route::put('/teams/{id}', [configurationController::class, 'modifyTeams'])->name('config.teams.modify');
    Route::delete('/teams/{id}', [configurationController::class, 'deleteTeams'])->name('config.teams.delete');
});

Route::middleware('auth')->prefix('league')->group(function () {
    Route::get('/{division_id}/standings', [leagueController::class, 'standings'])->name('league.standing');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
