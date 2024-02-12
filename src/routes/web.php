<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\TeamController;
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

Route::get("/", function () {
    return view("gamesDashboard");
});

Route::post('/clearData', [TeamController::class,'clearData']);
Route::post('/generateTeams', [TeamController::class,'generateTeams']);
Route::post('/simulateDivisionGames', [GameController::class,'simulateDivisionGames']);
Route::post('/simulatePlayOffGames', [GameController::class,'simulatePlayOffGames']);
Route::post('/simulateSemiFinalGames', [GameController::class,'simulateSemiFinalGames']);
Route::post('/simulateFinalGames', [GameController::class,'simulateFinalGames']);

