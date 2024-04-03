<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArmyResource;
use App\Models\Bases;

class ArmiesController extends Controller
{
    public function fetch ($base_id)
    {
        $base = $this->checkBaseAndUser($base_id);
        if(!$base instanceof Bases){
            return $base;
        }

        $army = $base->army;
        if(!$army){
            return response()->json(self::getApiErrorMessage('Resources Information missing.'));
        }
        return new ArmyResource($army);
    }
}
