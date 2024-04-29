<?php

use App\Http\Controllers\ExpeditionsController;
use App\Models\Expeditions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;

/**
 * This is the schedule to trigger the ExpeditionController tasks.
 * We need this to regularly run and check if actions need to be performed on Expeditions.
 */
Schedule::call(function () {
    // start all idle expeditions
    $expeditions = Expeditions::where('status', '=', 'idle')->get();
    $controller = new ExpeditionsController();
    foreach ($expeditions as $ex){
        $controller->start($ex);
    }

    $expeditions = Expeditions::where('status', '=', 'started')->get();
    foreach ($expeditions as $ex){
        if($ex->started_at->addMinutes($ex->duration) < Carbon::now()){
            $controller->resolve($ex);
        }
    }
})->everyFiveSeconds();



