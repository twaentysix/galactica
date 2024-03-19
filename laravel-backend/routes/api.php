<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::POST('/auth/login', [AuthenticationController::class, 'authenticate']);
Route::POST('/auth/register', [AuthenticationController::class, 'register']);
