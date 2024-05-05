<?php

use App\Http\Controllers\BarracksController;
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

Route::middleware(ApiAuth::class)->get('/bases',[BasesController::class, 'fetchBases']);
Route::middleware(ApiAuth::class)->get('/resources/{base_id}',[ResourceController::class, 'fetch']);
Route::middleware(ApiAuth::class)->get('/harbour/{base_id}',[HarboursController::class, 'fetch']);

Route::prefix('bases')->middleware(ApiAuth::class)->controller(BasesController::class)->group(function () {
    Route::GET('/','fetchBases');
    Route::POST('/create', 'create');
    Route::PATCH('/upgrade', 'upgrade');
});

Route::prefix('fleets')->middleware(ApiAuth::class)->controller(FleetsController::class)->group(function () {
    Route::GET('/{base_id}','fetch');
    Route::POST('/create','create');
    Route::PATCH('/update', 'update');
});

Route::prefix('collectors')->middleware(ApiAuth::class)->controller(CollectorsController::class)->group(function () {
    Route::GET('/{base_id}','fetch');
    Route::PATCH('/upgrade','upgrade');
    Route::PATCH('/collect','collect');
});

Route::prefix('expeditions')->middleware(ApiAuth::class)->controller(ExpeditionsController::class)->group(function () {
    Route::POST('/register','register');
});

Route::prefix('barracks')->middleware(ApiAuth::class)->controller(BarracksController::class)->group(function () {
    Route::POST('/build','build');
});
