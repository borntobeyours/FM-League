<?php

use App\Http\Controllers\configurationController;
use App\Http\Controllers\cupController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\DBPlayerController;
use App\Http\Controllers\leagueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\transferController;
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

Route::middleware('auth')->prefix('database')->group(function () {
    Route::get('/player', [DBPlayerController::class, 'player'])->name('db.player');
    Route::post('/player', [DBPlayerController::class, 'importPlayer']);
    Route::get('/players/{teamId}', [DBPlayerController::class, 'getPlayersByTeam']);
});

Route::middleware('auth')->prefix('league')->group(function () {
    Route::get('/{division_id}/standings', [leagueController::class, 'standings'])->name('league.standing');
    Route::get('/{division_id}/results', [leagueController::class, 'results'])->name('league.results');
    Route::post('/{division_id}/results', [leagueController::class, 'saveResults']);
    Route::get('/{division_id}/statistics/goal-score', [leagueController::class, 'statisticsGoal'])->name('league.statistic.goal');
    Route::get('/{division_id}/statistics/assist', [leagueController::class, 'statisticsAssist'])->name('league.statistic.assist');
    Route::get('/{division_id}/statistics/yellow-card', [leagueController::class, 'statisticsYC'])->name('league.statistic.yc');
    Route::get('/{division_id}/statistics/red-card', [leagueController::class, 'statisticsRC'])->name('league.statistic.rc');
});

Route::middleware('auth')->prefix('cup')->group(function () {
    Route::get('results', [cupController::class, 'results'])->name('cup.results');
    Route::post('results', [cupController::class, 'saveResults']);
    Route::get('statistics/goal-score', [cupController::class, 'statisticsGoal'])->name('cup.statistic.goal');
    Route::get('statistics/assist', [cupController::class, 'statisticsAssist'])->name('cup.statistic.assist');
    Route::get('statistics/yellow-card', [cupController::class, 'statisticsYC'])->name('cup.statistic.yc');
    Route::get('statistics/red-card', [cupController::class, 'statisticsRC'])->name('cup.statistic.rc');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('transfer')->group(function () {
    Route::get('/', [transferController::class, 'index'])->name('transfer');
    Route::post('/', [transferController::class, 'save']);
});

require __DIR__.'/auth.php';
