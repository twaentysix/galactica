<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlanetsCollection;
use App\Http\Resources\PlanetsResource;
use App\Models\Planets;

class PlanetsController extends Controller
{
    /**
     * @return PlanetsCollection
     */
    public function fetchAll ()
    {
        return new PlanetsCollection(Planets::all());
    }

    public function fetchOne ($id)
    {
        $planet = Planets::find($id);
        if(!$planet){
            return response()->json(self::getApiErrorMessage('There is no planet with the id: ' . $id, 200));
        }
        return new PlanetsResource($planet);
    }
}
