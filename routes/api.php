<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('teams')->group(function () {
    Route::apiResource('/', \App\Http\Controllers\Omen\TeamController::class);
});
Route::prefix('fixtures')->group(function () {
    Route::get('/generate', [\App\Http\Controllers\Omen\FixtureController::class, 'generate']);
    Route::get('/', [\App\Http\Controllers\Omen\FixtureController::class, 'generate']);

    Route::get('/simulate/week', [\App\Http\Controllers\Omen\FixtureController::class, 'simulateWeek']);
    Route::get('/simulate/{pot_id}/{week}', [\App\Http\Controllers\Omen\FixtureController::class, 'getPotFixture']);
    #Route::get('/', [\App\Http\Controllers\Omen\FixtureController::class, 'index']);
});
Route::prefix('pots')->group(function () {
    Route::get('/', [\App\Http\Controllers\Omen\PotController::class, 'index']);
    Route::get('/{pot_id}', [\App\Http\Controllers\Omen\PotController::class, 'listTeamsByPot']);
    Route::get('/weekly/{pot_id}', [\App\Http\Controllers\Omen\PotController::class, 'weeklyFixture']);
});
Route::get('/calculate/{remainingWeeks}/{teamPoints}/{leaderPoints}', [\App\Http\Controllers\Omen\PredictionController::class, 'calculateChampionshipPercentage']);
