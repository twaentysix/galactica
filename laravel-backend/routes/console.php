<?php

use App\Http\Controllers\ExpeditionsController;
use App\Models\Expeditions;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    // start all idle expeditions
    $expeditions = Expeditions::where('status', '=', 'idle')->get();
    $controller = new ExpeditionsController();
    foreach ($expeditions as $ex){
        $controller->start($ex->fleet);
    }
    // start all idle expeditions
})->everyFiveSeconds();



