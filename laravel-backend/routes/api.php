<?php

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
Route::middleware(ApiAuth::class)->get('/ship-types/{base_id}',[ShipTypesController::class, 'fetch']);
Route::middleware(ApiAuth::class)->get('/collectors/{base_id}',[CollectorsController::class, 'fetch']);

