<?php

namespace App\Http\Controllers;

use App\Http\Resources\HarbourResource;
use App\Models\Bases;
use Illuminate\Http\Request;

class BarracksController extends Controller
{
    public function build(Request $request)
    {
        $base_id = $request->input('base_id');
        $type = $request->input('type');
        $amount = $request->input('amount');

        $base = self::checkBaseAndUser($base_id);
        if(!$base instanceof Bases){
            return $base;
        }
        if(!$type){
            return response()->json(self::getApiErrorMessage('Ship-type missing.', 200));
        }
        if(!$amount){
            return response()->json(self::getApiErrorMessage('Amount missing.',200));
        }

        $harbour = $base->harbour;
        switch($type){
            case 'transporter':
                $rs = $this->applyResources($base, $amount, 6, 4, 3);
                if(!$rs){
                    return response()->json(self::getApiErrorMessage('Not enough resources!', 200));
                }
                $harbour->update([
                    'transporter' => $harbour->transporter + $amount,
                ]);
                break;
            case 'light_fighter':
                    if($base->level < 2){
                        return response()->json(self::getApiErrorMessage('You need to upgrade your base!', 200));
                    }
                    $rs = $this->applyResources($base, $amount, 9, 6, 5);
                    if(!$rs){
                        return response()->json(self::getApiErrorMessage('Not enough resources!', 200));
                    }
                    $harbour->update([
                        'light_fighter' => $harbour->light_fighter + $amount,
                    ]);
                break;
            case 'heavy_fighter':
                    if($base->level < 4){
                        return response()->json(self::getApiErrorMessage('You need to upgrade your base!',200));
                    }
                    $rs = $this->applyResources($base, $amount, 13, 10, 8);
                    if(!$rs){
                        return response()->json(self::getApiErrorMessage('Not enough resources!', 200));
                    }
                    $harbour->update([
                        'heavy_fighter' => $harbour->heavy_fighter + $amount,
                    ]);
                break;
            case 'battleships':
            case 'battleship':
                    if($base->level < 6){
                        return response()->json(self::getApiErrorMessage('You need to upgrade your base!', 200));
                    }
                    $rs = $this->applyResources($base, $amount, 16, 14, 12);
                    if(!$rs){
                        return response()->json(self::getApiErrorMessage('Not enough resources!', 200));
                    }
                    $harbour->update([
                        'battleships' => $harbour->battleships + $amount,
                    ]);
                break;
            case 'cruiser':
                    if($base->level < 10){
                        return response()->json(self::getApiErrorMessage('You need to upgrade your base!', 200));
                    }
                    $rs = $this->applyResources($base, $amount, 18, 16, 14);
                    if(!$rs){
                        return response()->json(self::getApiErrorMessage('Not enough resources!', 200));
                    }
                    $harbour->update([
                        'cruiser' => $harbour->cruiser + $amount,
                    ]);
                break;
            default:
                return response()->json(self::getApiErrorMessage('There is no such ship type.', 200));
        }
        $harbour->save();
        return new HarbourResource($harbour);
    }

    /**
     * @param Bases $base
     * @param $amount
     * @param $metal
     * @param $gas
     * @param $gems
     * @return bool
     */
    private function applyResources(Bases $base, $amount, $metal, $gas, $gems)
    {
        $resources = $base->resources;
        $metal = $metal * $amount;
        $gas = $gas * $amount;
        $gems = $gems * $amount;
        if($resources->metal < $metal || $resources->gas < $gas || $resources->gems < $gems){
            return false;
        }
        $resources->update([
            'metal' => $resources->metal - $metal,
            'gas' => $resources->gas - $gas,
            'gems' => $resources->gems - $gems,
        ]);
        return true;
    }
}
