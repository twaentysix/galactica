<?php

namespace App\Http\Controllers;

use App\Models\Bases;
use App\Models\ShipTypes;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    static function getApiErrorMessage(string $message){
        return [
            'data' => null,
            'error' => [
                'details'=>(object)[],
                'message' => $message,
                'name' => 'ApplicationError',
                'status'=>400,
            ],

        ];
    }

    public function checkBaseAndUser ($base_id)
    {
        $user = Auth::guard('localAuth')->user();
        if(!$user){
            return response()->json(self::getApiErrorMessage('Authentication failed'));
        }

        $base = Bases::find($base_id);
        if(!$base){
            return response()->json(self::getApiErrorMessage('Base not found'));
        }

        if($base->user != $user){
            return response()->json(self::getApiErrorMessage('This is not your base!'));
        }
        return $base;
    }
}
