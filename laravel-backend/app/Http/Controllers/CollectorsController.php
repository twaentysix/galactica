<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArmyResource;
use App\Http\Resources\CollectorsCollection;
use App\Models\Bases;
use Illuminate\Http\Request;

class CollectorsController extends Controller
{
    public function fetch ($base_id)
    {
        $base = $this->checkBaseAndUser($base_id);
        if(!$base instanceof Bases){
            return $base;
        }

        $collectors = $base->collectors;
        if(!$collectors){
            return response()->json(self::getApiErrorMessage('Resources Information missing.'));
        }
        return new CollectorsCollection($collectors);
    }
}
