<?php

namespace App\Http\Controllers;

use App\Models\Bases;
use App\Models\ShipTypes;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    static function getApiErrorMessage(string $message, int $status){
        return [
            'data' => null,
            'error' => [
                'details'=>(object)[],
                'message' => $message,
                'name' => 'ApplicationError',
                'status'=>$status,
            ],

        ];
    }

    public function checkBaseAndUser ($base_id)
    {
        $user = Auth::guard('localAuth')->user();
        if(!$user){
            return response()->json(self::getApiErrorMessage('Authentication failed', 403));
        }

        $base = Bases::find($base_id);
        if(!$base){
            return response()->json(self::getApiErrorMessage('Base not found', 200));
        }

        if($base->user != $user){
            return response()->json(self::getApiErrorMessage('This is not your base!', 200));
        }
        return $base;
    }

    public function checkUser ()
    {
        $user = Auth::guard('localAuth')->user();
        if(!$user){
            return response()->json(self::getApiErrorMessage('Authentication failed', 403));
        }
        return $user;
    }
}
