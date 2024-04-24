<?php

namespace App\Http\Controllers;

use App\Http\Resources\HarbourResource;
use App\Http\Resources\FleetsCollection;
use App\Models\Bases;
use Illuminate\Http\Request;

class FleetsController extends Controller
{
    public function fetch ($base_id)
    {
        $base = $this->checkBaseAndUser($base_id);
        if(!$base instanceof Bases){
            return $base;
        }

        $fleets = $base->harbour->fleets;
        if(!$fleets){
            return response()->json(self::getApiErrorMessage('Resources Information missing.'));
        }
        return new FleetsCollection($fleets);
    }

    public function create (){
        //TODO Darf nicht Pirates im Namen haben!!
    }
}
