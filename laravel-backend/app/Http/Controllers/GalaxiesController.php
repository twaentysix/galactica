<?php

namespace App\Http\Controllers;

use App\Http\Resources\GalaxiesCollection;
use App\Models\Galaxies;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GalaxiesController extends Controller
{
    /**
     * @return GalaxiesCollection|JsonResponse
     */
    public function fetchAll () : GalaxiesCollection|JsonResponse
    {
        $user = Auth::guard('localAuth')->user();

        if(!$user){
            return response()->json(self::getApiErrorMessage("Authentication failed"));
        }

        $galaxies = Galaxies::all();

        return new GalaxiesCollection($galaxies);
    }
}
