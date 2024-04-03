<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArmyResource;
use App\Http\Resources\TroopsCollection;
use App\Models\Bases;
use Illuminate\Http\Request;

class TroopsController extends Controller
{
    public function fetch ($base_id)
    {
        $base = $this->checkBaseAndUser($base_id);
        if(!$base instanceof Bases){
            return $base;
        }

        $troops = $base->army->troops;
        if(!$troops){
            return response()->json(self::getApiErrorMessage('Resources Information missing.'));
        }
        return new TroopsCollection($troops);
    }
}
