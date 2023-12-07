<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [\App\Http\Controllers\TeamController::class, 'index'])->name('home');
Route::post('tournaments', [\App\Http\Controllers\TournamentController::class, 'store'])->name('tournaments.store');
Route::get('tournaments', [\App\Http\Controllers\TournamentController::class, 'index'])->name('tournaments.index');
Route::get('tournaments/{tournamentId}/matches', [\App\Http\Controllers\MatchController::class, 'getMatchListGroupedByWeek'])->name('matches.getMatchListGroupedByWeek');
Route::post('tournaments/{tournamentId}/matches/{week}/play', [\App\Http\Controllers\MatchController::class, 'playWeek'])->name('tournaments.match.playWeek');
Route::post('tournaments/{tournamentId}/matches/play', [\App\Http\Controllers\MatchController::class, 'playAll'])->name('tournaments.match.playAll');
Route::get('tournaments/{tournamentId}/matches/{week}', [\App\Http\Controllers\MatchController::class, 'getMatchListByWeek'])->name('tournaments.match.getMatchListByWeek');

