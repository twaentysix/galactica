<?php

use App\Http\Controllers\ExpeditionsController;
use App\Http\Controllers\HarboursController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BasesController;
use App\Http\Controllers\CollectorsController;
use App\Http\Controllers\GalaxiesController;
use App\Http\Controllers\PlanetsController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ShipTypesController;
use App\Http\Controllers\FleetsController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuth;
use App\Models\Expeditions;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthenticationController::class)->group(function () {
    Route::POST('/login','authenticate');
    Route::POST('/register', 'register');
});

Route::prefix('galaxies')->middleware(ApiAuth::class)->controller(GalaxiesController::class)->group(function () {
    Route::GET('/','fetchAll');
    Route::GET('/{id}', 'fetchOne');
});

Route::prefix('planets')->middleware(ApiAuth::class)->controller(PlanetsController::class)->group(function () {
    Route::GET('/','fetchAll');
    Route::GET('/{id}', 'fetchOne');
});

Route::prefix('users')->middleware(ApiAuth::class)->controller(UserController::class)->group(function () {
    Route::GET('/me','fetchLoggedInUser');
    Route::GET('/{id}', 'w');
});

Route::middleware(ApiAuth::class)->get('/base',[BasesController::class, 'fetchBase']);
Route::middleware(ApiAuth::class)->get('/bases',[BasesController::class, 'fetchBases']);
Route::middleware(ApiAuth::class)->get('/resources/{base_id}',[ResourceController::class, 'fetch']);
Route::middleware(ApiAuth::class)->get('/harbour/{base_id}',[HarboursController::class, 'fetch']);
Route::middleware(ApiAuth::class)->get('/fleets/{base_id}',[FleetsController::class, 'fetch']);
Route::middleware(ApiAuth::class)->get('/ship-types',[ShipTypesController::class, 'fetch']);

Route::prefix('collectors')->middleware(ApiAuth::class)->controller(CollectorsController::class)->group(function () {
    Route::GET('/{base_id}','fetch');
    Route::PATCH('/upgrade','upgrade');
    Route::PATCH('/collect','collect');
});

Route::prefix('expeditions')->middleware(ApiAuth::class)->controller(ExpeditionsController::class)->group(function () {
    Route::POST('/register','register');
});


Route::prefix('test')->controller(ExpeditionsController::class)->group(function () {
    Route::GET('/resolve', function () {
        $controller = new ExpeditionsController();
        $expeditions = Expeditions::where('status', '=', 'started')->get();
        foreach ($expeditions as $ex){
            $opponentStrength = $controller->resolve($ex);
            if($ex->battle){
                $opponentBaseStrength = $ex->battle->opponent->getBattleStrength();
                // Calculate total strength of the second fleet
                $randomAdjustment = rand(0, $ex->fleet->getBattleStrength() * 0.2);
                $opponentStrength = $opponentBaseStrength + $randomAdjustment;
                $randomFactor = rand(0, 100);
                $modifiedFleetStrength = $ex->fleet->getBattleStrength() + ($randomFactor * 0.5);
                $scalingFactor = $modifiedFleetStrength / $opponentStrength;
                $winningThreshold = 1 - ($opponentStrength / ($opponentStrength + $modifiedFleetStrength * $scalingFactor));
                $randomNumber = rand(0, 100) / 100;
                if ($randomNumber < $winningThreshold) {
                    $won = true;
                    $destructionMultiplier = (rand(5, 10) * (1/$winningThreshold));
                }
                else{
                    $won = false;
                    $destructionMultiplier = (rand(50, 60) * (1/$winningThreshold));
                }
                $destructionRate = min(80, ($ex->fleet->getBattleStrength() / ($ex->fleet->getBattleStrength() + $opponentStrength)) * $destructionMultiplier);

            }

            return response()->json([
                'battle' => $ex->battle,
                'metal' => $ex->metal,
                'gems' => $ex->gems,
                'gas' => $ex->gas,
                'strength' => $ex->fleet->getBattleStrength(),
                'opponentStrength' => $opponentStrength,
                'threshold' => $winningThreshold,
                'destructionRate' => $destructionRate,
                'modifiedStrength' => $modifiedFleetStrength,
                'won' => $won,
            ]);
        }
    });
    Route::GET('/start', function () {
        $expeditions = Expeditions::where('status', '=', 'idle')->get();
        $controller = new ExpeditionsController();
        foreach ($expeditions as $ex){
            $controller->start($ex);
            return response()->json([
                'battle' => $ex->battle,
                'metal' => $ex->metal,
                'gems' => $ex->gems,
                'gas' => $ex->gas,
            ]);
        }
    });
});


