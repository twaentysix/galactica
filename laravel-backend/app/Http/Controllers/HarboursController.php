<?php

namespace App\Http\Controllers;

use App\Http\Resources\HarbourResource;
use App\Models\Bases;
use App\Models\Harbours;

class HarboursController extends Controller
{
    public function fetch ($base_id)
    {
        $base = $this->checkBaseAndUser($base_id);
        if(!$base instanceof Bases){
            return $base;
        }

        $harbour = $base->harbour;
        if(!$harbour){
            return response()->json(self::getApiErrorMessage('Resources Information missing.', 200));
        }
        return new HarbourResource($harbour);
    }
}
