<?php

namespace App\Http\Controllers;
use App\Models\Fleets;
use Illuminate\Http\Request;

interface ActionController{

    /**
     * Every Action is registered by an api Call.
     * To get information about the Action, the request object of that call is necessary.
     * @param Request $request
     * @return mixed
     */
    function register(Request $request);

    /**
     * Actions can only be performed by fleets.
     * The resolve function needs to know which fleets action is being resolved.
     * @param $fleet_id
     * @return void
     */
    function resolve(Fleets $fleet);

    /**
     * Each Action has to be started.
     * Since only fleets can perform actions, we need to pass a fleet_id.
     * @param $fleet_id
     * @return mixed
     */
    function start(Fleets $fleet);
}

