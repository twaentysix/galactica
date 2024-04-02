<?php

namespace App\Http\Controllers;

use App\Http\Resources\BasesCollection;
use App\Http\Resources\BasesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BasesController extends Controller
{
    public function fetchBases ()
    {
        $user = Auth::guard('localAuth')->user();
        if(!$user){
            return response()->json(self::getApiErrorMessage('Authentication failed'));
        }

        return new BasesCollection($user->bases);
    }
}
