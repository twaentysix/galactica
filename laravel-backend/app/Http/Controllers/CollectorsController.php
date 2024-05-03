<?php

namespace App\Http\Controllers;

use App\Http\Resources\BasesResource;
use App\Http\Resources\CollectorsCollection;
use App\Models\Bases;
use App\Models\ResourceCollectors;
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
            return response()->json(self::getApiErrorMessage('Resources Information missing.', 200));
        }
        return new CollectorsCollection($collectors);
    }

    public function collect(Request $request)
    {
        $id = $request->input('id');
        if(!$id){
            return response()->json(self::getApiErrorMessage('Missing ID of Collector!', 200));
        }
        $collector = ResourceCollectors::find($id);
        $base = $collector->base;
        $base = $this->checkBaseAndUser($base->id);
        if(!$base instanceof Bases){
            return $base;
        }
        $collector->collect();
        return new BasesResource($base);
    }

    public function upgrade(Request $request)
    {
        $id = $request->input('id');
        if(!$id){
            return response()->json(self::getApiErrorMessage('Missing ID of Collector!', 200));
        }
        $collector = ResourceCollectors::find($id);
        $base = $collector->base;
        $base = $this->checkBaseAndUser($base->id);
        if(!$base instanceof Bases){
            return $base;
        }
        $upgraded = $collector->upgrade();
        if(!$upgraded){
            return response()->json(Controller::getApiErrorMessage('Not enough resources', 200));
        }

        return new BasesResource($base);
    }
}
