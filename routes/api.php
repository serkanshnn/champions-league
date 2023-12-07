<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('tournaments', [\App\Http\Controllers\TournamentController::class, 'store'])->name('tournaments.store');
Route::get('tournaments/{tournamentId}/matches', [\App\Http\Controllers\MatchController::class, 'getMatchListGroupedByWeek'])->name('matches.getMatchListGroupedByWeek');
Route::get('tournaments/{tournamentId}/stats', [\App\Http\Controllers\TeamController::class, 'index'])->name('teams.stats');
Route::post('match/{week}/play', [\App\Http\Controllers\MatchController::class, 'playMatch'])->name('match.play');
