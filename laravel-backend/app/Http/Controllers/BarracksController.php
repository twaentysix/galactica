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
            return response()->json(self::getApiErrorMessage('Ship-type missing.'));
        }
        if(!$amount){
            return response()->json(self::getApiErrorMessage('Amount missing.'));
        }

        $harbour = $base->harbour;
        switch($type){
            case 'light_fighter':
                    $rs = $this->applyResources($base, $amount, 50, 25, 5);
                    if(!$rs){
                        return response()->json(self::getApiErrorMessage('Not enough resources!'));
                    }
                    $harbour->update([
                        'light_fighter' => $harbour->light_fighter + $amount,
                    ]);
                break;
            case 'heavy_fighter':
                    $rs = $this->applyResources($base, $amount, 70, 35, 10);
                    if(!$rs){
                        return response()->json(self::getApiErrorMessage('Not enough resources!'));
                    }
                    $harbour->update([
                        'heavy_fighter' => $harbour->heavy_fighter + $amount,
                    ]);
                break;
            case 'battleships':
            case 'battleship':
                    $rs = $this->applyResources($base, $amount, 80, 45, 15);
                    if(!$rs){
                        return response()->json(self::getApiErrorMessage('Not enough resources!'));
                    }
                    $harbour->update([
                        'battleships' => $harbour->battleships + $amount,
                    ]);
                break;
            case 'cruiser':
                    $rs = $this->applyResources($base, $amount, 90, 50, 12);
                    if(!$rs){
                        return response()->json(self::getApiErrorMessage('Not enough resources!'));
                    }
                    $harbour->update([
                        'cruiser' => $harbour->cruiser + $amount,
                    ]);
                break;
            case 'transporter':
                    $rs = $this->applyResources($base, $amount, 40, 15, 2);
                    if(!$rs){
                        return response()->json(self::getApiErrorMessage('Not enough resources!'));
                    }
                    $harbour->update([
                        'transporter' => $harbour->transporter + $amount,
                    ]);
                break;
            default:
                return response()->json(self::getApiErrorMessage('There is no such ship type.'));
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
