<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BasesController;
use App\Http\Controllers\GalaxiesController;
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
    Route::GET('/{id}', 'fetchSpecificUser');
});

Route::middleware(ApiAuth::class)->get('/base',[BasesController::class, 'fetchBase']);
Route::middleware(ApiAuth::class)->get('/bases',[BasesController::class, 'fetchBases']);
Route::middleware(ApiAuth::class)->get('/resources',[ResourceController::class, 'fetchBase']);
Route::middleware(ApiAuth::class)->get('/army',[ArmiesController::class, 'fetchBase']);
Route::middleware(ApiAuth::class)->get('/troops',[TroopsController::class, 'fetchBase']);
Route::middleware(ApiAuth::class)->get('/ship-types',[ShipTypesController::class, 'fetchBase']);
Route::middleware(ApiAuth::class)->get('/collectors',[CollectorsController::class, 'fetchBase']);

