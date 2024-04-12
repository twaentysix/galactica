<?php

namespace App\Http\Controllers;

use App\Http\Resources\HarbourResource;
use App\Models\Bases;

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
            return response()->json(self::getApiErrorMessage('Resources Information missing.'));
        }
        return new HarbourResource($harbour);
    }
}
