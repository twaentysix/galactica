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
            return response()->json(self::getApiErrorMessage('Not enough data provided (fleet id missing)', 200));
        }
        if(!$duration){
            return response()->json(self::getApiErrorMessage('Not enough data provided (duration missing)', 200));
        }

        $fleet = Fleets::find($fleet_id);
        if($fleet->busy){
            return response()->json(self::getApiErrorMessage('This Fleet is busy!', 200));
        }

        $base = $fleet->harbour->base;

        $base = self::checkBaseAndUser($base->id);
        if(!$base instanceof Bases){
            return $base;
        }
        //TODO change to fleet strength
        $fleetMultiplier = $fleet->getExpeditionResourceMultiplier();
        if($fleetMultiplier < 1.5){
            return response()->json(self::getApiErrorMessage('Your fleet is not strong enough.', 200));
        }

        $metal = round(self::$BASE_METAL_REWARD * $fleetMultiplier * (float)rand(1, 1.2) + self::$BASE_METAL_REWARD * $duration ,2);
        $gas = round(self::$BASE_GAS_REWARD * $fleetMultiplier * (float)rand(1, 1.2) + self::$BASE_GAS_REWARD * $duration, 2);
        $gems = round(self::$BASE_GEMS_REWARD * $fleetMultiplier * (float)rand(1, 1.2) +  self::$BASE_GEMS_REWARD * $duration,2);

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
        if(!$model instanceof Expeditions){
            return false;
        }

        $battleHappens = 0.04 * $model->duration >= rand(0, 10000) / 10000;

        if($battleHappens){
            $battleController = new ExpeditionBattleController();
            $battle = $battleController->create($model->fleet, $battleController->getPirateFleet($model->fleet));
            $battle->expedition()->associate($model);
            $battleController->resolve($battle);
        }

        if($model->battle){
            $status = $model->battle->won ? 'succeeded' : 'failed';
        }else{
            $status = 'succeeded';
        }

        $model->update([
            'status' => $status,
            'ended_at' => Carbon::now(),
        ]);
        $model->save();

        $fleet = $model->fleet;
        $fleet->update([
            'busy' => false,
        ]);
        $fleet->save();

        if($status == 'succeeded'){
            $resources = $model->fleet->harbour->base->resources;
            $metal = $resources->metal + $model->metal;
            $gas = $resources->gas + $model->gas;
            $gems = $resources->gems + $model->gems;
            $resources->update([
                'metal' => $metal,
                'gems' => $gems,
                'gas' => $gas
            ]);
            $resources->save();
        }
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
