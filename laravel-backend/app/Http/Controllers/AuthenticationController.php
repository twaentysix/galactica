<?php

namespace App\Http\Controllers;

use App\CustomGuards\JwtHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function authenticate (Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // TODO password = hash in der request --> hier testen

        if(Auth::guard('localAuth')->attempt($credentials)){
            $user = Auth::guard('localAuth')->user();
            if(!$user->hasVerifiedEmail()){
                return response()->json(Controller::getApiErrorMessage("Your account email is not confirmed"), 400);
            }
            $token = JwtHelper::generateToken($user);
            return response()->json(['jwt' => $token, 'user' => new User($user)]);
        }
        return response()->json(Controller::getApiErrorMessage("Invalid credentials"), 401);
    }

    public function register() {
        // TODO registration
        $data = request()->post();
        if(!$data){
            return response()->json(Controller::getApiErrorMessage("Missing data"),400);
        }
        return response()->json([
            'user' => [
            ]
        ]);
    }
}
