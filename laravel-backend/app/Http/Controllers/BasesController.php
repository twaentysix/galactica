<?php

namespace App\Http\Controllers;

use App\Http\Resources\BasesCollection;
use App\Http\Resources\BasesResource;
use App\Http\Resources\PlanetsResource;
use App\Models\Bases;
use App\Models\Galaxies;
use App\Models\Harbours;
use App\Models\Planets;
use App\Models\ResourceCollectors;
use App\Models\Resources;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasesController extends Controller
{
    public function fetchBases ()
    {
        $user = Auth::guard('localAuth')->user();
        if(!$user){
            return response()->json(self::getApiErrorMessage('Authentication failed', 200));
        }

        return new BasesCollection($user->bases);
    }

    public function create (Request $request)
    {
        $name = $request->input('name');
        $galaxy_id = $request->input('galaxy_id');

        if(!$name){
            return response()->json(self::getApiErrorMessage('No name for the Base given!', 200));
        }

        if(!$galaxy_id){
            return response()->json(self::getApiErrorMessage('No galaxy id given!', 200));
        }

        $galaxy = Galaxies::find($galaxy_id);
        if(!$galaxy){
            return response()->json(self::getApiErrorMessage('No Galaxy with given id found!', 200));
        }

        $user = self::checkUser();
        if(!$user instanceof User){
            return $user;
        }
        if($user->bases()->where('name', '=', $name)->exists()){
            return response()->json(self::getApiErrorMessage('You already have a base named '. $name, 200));
        }
       $base = Bases::create([
           'name' => $name,
           'created_at' => Carbon::now(),
           'last_upgraded_at' => Carbon::now(),
       ]);
        $base->user()->associate($user);
        $user->load('bases');

        $harbour = Harbours::create();
        $harbour->base()->associate($base);
        $harbour->save();

        $resources = Resources::create();
        $resources->base()->associate($base);
        $resources->save();

        $metalCollector = ResourceCollectors::create([
            'type' => 'metal',
            'last_collected' => Carbon::now(),
        ]);
        $metalCollector->base()->associate($base);

        $gasCollector = ResourceCollectors::create([
            'type' => 'gas',
            'last_collected' => Carbon::now(),
        ]);
        $gasCollector->base()->associate($base);

        $gemsCollector = ResourceCollectors::create([
            'type' => 'gems',
            'last_collected' => Carbon::now(),
        ]);
        $gemsCollector->base()->associate($base);

        $gasCollector->save();
        $metalCollector->save();
        $gemsCollector->save();

        $planet = Planets::create(['name' => $name]);
        $base->planet()->associate($planet);
        $planet->galaxy()->associate($galaxy);
        $planet->save();
        $galaxy->load('planets');
        $base->save();
        $planet->load('base');

        return new PlanetsResource($planet);
    }

    public function upgrade (Request $request)
    {
        $base_id = $request->input('base_id');
        if(!$base_id){
            return response()->json(self::getApiErrorMessage('Base id missing!', 200));
        }

        $base = self::checkBaseAndUser($base_id);
        if(!$base instanceof Bases){
            return $base;
        }

        if($base->level >= Bases::$MAX_LEVEL){
            return response()->json(self::getApiErrorMessage('Your Base is already max level!', 200));
        }

        $resources = $base->resources;
        $cost = $base->getUpgradeCost();

        if($resources->metal < $cost['metal']){
            return response()->json(self::getApiErrorMessage('You do not have enough Metal.', 200));
        }

        if($resources->gas < $cost['gas']){
            return response()->json(self::getApiErrorMessage('You do not have enough Gas.', 200));
        }

        if($resources->gems < $cost['gems']){
            return response()->json(self::getApiErrorMessage('You do not have enough Gems.', 200));
        }

        $resources->update([
            'metal' => $resources->metal - $cost['metal'],
            'gas' => $resources->metal - $cost['gas'],
            'gems' => $resources->metal - $cost['gems'],
        ]);
        $resources->save();

        $reward = $base->upgrade();

        $base->load('resources');
        return (new BasesResource($base))->withReward($reward);
    }
}
