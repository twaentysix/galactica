<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
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
     * Actions are performed on models, therefore we need to pass a model.
     * The resolve function needs to know which model action is being resolved.
     * @param Model $model
     * @return void
     */
    function resolve(Model $model);

    /**
     * Each Action has to be started.
     * Actions are performed on models, therefore we need to pass a model.
     * @param Model $model
     * @return mixed
     */
    function start(Model $model);
}

