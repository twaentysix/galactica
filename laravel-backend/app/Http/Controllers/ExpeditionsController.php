<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpeditionResource;
use App\Models\Bases;
use App\Models\Expeditions;
use App\Models\Fleets;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LaravelIdea\Helper\App\Models\_IH_Bases_C;

class ExpeditionsController extends Controller implements ActionController
{
    static float $BASE_METAL_REWARD = 50;
    static float $BASE_GAS_REWARD = 30;
    static float $BASE_GEMS_REWARD = 10;

    /**
     * @param Request $request
     * @return ExpeditionResource|Bases|Bases[]|JsonResponse|_IH_Bases_C|mixed
     */
    function register(Request $request)
    {
        $fleet_id = $request->input('fleet_id');
        $duration = $request->input('duration');

        if(!$fleet_id){
            return response()->json(self::getApiErrorMessage('Not enough data provided (fleet id missing)'));
        }
        if(!$duration){
            return response()->json(self::getApiErrorMessage('Not enough data provided (duration missing)'));
        }

        $fleet = Fleets::find($fleet_id);
        if($fleet->busy){
            return response()->json(self::getApiErrorMessage('This Fleet is busy!'));
        }

        $base = $fleet->harbour->base;

        $base = self::checkBaseAndUser($base->id);
        if(!$base instanceof Bases){
            return $base;
        }

        $fleetMultiplier = $fleet->getExpeditionResourceMultiplier();
        if($fleetMultiplier < 1.5){
            return response()->json(self::getApiErrorMessage('Your fleet is not strong enough.'));
        }

        $metal = round(self::$BASE_METAL_REWARD * $fleetMultiplier * (float)rand(1, 1.2) ,2);
        $gas = round(self::$BASE_GAS_REWARD * $fleetMultiplier * (float)rand(1, 1.2), 2);
        $gems = round(self::$BASE_GEMS_REWARD * $fleetMultiplier * (float)rand(1, 1.2),2);

        $expedition = Expeditions::create([
            'status' => 'idle',
            'duration' => $duration,
            'metal' => $metal,
            'gas' => $gas,
            'gems' => $gems,
        ]);
        $expedition->fleet()->associate($fleet);
        $expedition->save();

        $fleet->update([
            'busy' => true,
        ]);
        $fleet->save();
        return new ExpeditionResource($expedition);
    }

    /**
     * @param Model $model
     * @return false|void
     * @var Expeditions $expedition
     */
    function resolve(Model $model)
    {
        // TODO: Implement resolve() method. --> battle and set resources and status of expedition
        // TODO: check if battle happend, resolve the battle
        // TODO: if expedition succeeded --> resources into base resources, update expedition
        if(!$model instanceof Expeditions){
            return false;
        }

        $battleHappens = 0.05 * $model->duration <= rand(0, 10000) / 10000;

        if($battleHappens){
            $battleController = new ExpeditionBattleController();
            $battle = $battleController->create($model->fleet, $battleController->getPirateFleet($model->fleet));
            $battle->expedition()->associate($model);
            $battleController->resolve($battle);
        }

        $model->update([
            'status' => 'succeeded',
            'ended_at' => Carbon::now(),
        ]);
        $model->save();
        $resources = $model->fleet->harbour->base->resources;
        $metal = $resources->metal + $model->metal;
        $gas = $resources->gas + $model->gas;
        $gems = $resources->gems + $model->gems;
        $resources->update([
            'metal' => $metal,
            'gems' => $gems,
            'gas' => $gas
        ]);
    }

    /**
     * @param Model $model
     * @return false|void
     * @var Expeditions $expedition
     */
    function start(Model $model)
    {
        if(!$model instanceof Expeditions){
            return false;
        }
        $model->update([
            'status' => 'started',
            'started_at' => Carbon::now(),
        ]);
        $model->save();
    }
}
