<?php

namespace App\Http\Controllers;

use App\Models\ShipTypes;

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
}
