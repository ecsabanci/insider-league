<?php

use App\Http\Controllers\LeagueController;
use Illuminate\Support\Facades\Route;

Route::get('/standings', [LeagueController::class, 'standings']);
Route::get('/fixtures', [LeagueController::class, 'fixtures']);

Route::post('/fixtures/generate', [LeagueController::class, 'generateFixtures']);
Route::post('/play-week', [LeagueController::class, 'playWeek']);
Route::post('/play-all', [LeagueController::class, 'playAll']);
Route::post('/reset', [LeagueController::class, 'reset']);
Route::get('/championship-predictions', [LeagueController::class, 'championshipPredictions']);
