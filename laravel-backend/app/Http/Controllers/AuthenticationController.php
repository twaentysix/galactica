<?php

namespace App\Http\Controllers;

use App\Guards\JwtHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function authenticate (LoginRequest $request)
    {
        $credentials = $request->validated();
        // TODO password = hash in der request --> hier testen
        if(Auth::guard('localAuth')->attempt($credentials)){
            $user = Auth::guard('localAuth')->user();
            if(!$user->hasVerifiedEmail()){
                return response()->json(Controller::getApiErrorMessage("Your account email is not confirmed"), 400);
            }
            $token = JwtHelper::generateToken($user);
            return response()->json(['jwt' => $token, 'user' => new UserResource($user)]);
        }
        return response()->json(Controller::getApiErrorMessage("Invalid credentials"), 401);
    }

    public function register(RegisterRequest $request) {
        $data = request()->post();
        if(!$data){
            return response()->json(Controller::getApiErrorMessage("Missing data"),400);
        }

        $data = $request->validated();
        $user = User::where('name', '=', $data['name'])->first();
        if($user){
            return response()->json(Controller::getApiErrorMessage("Username already taken."),400);
        }

        $user = User::where('email', '=', $data['email'])->first();
        if($user){
            return response()->json(Controller::getApiErrorMessage("Email already taken."),400);
        }

        // TODO send email on verification
        $user = User::create(
            [
                'name' => $data['name'],
                'password' => $data['password'],
                'email' => $data['email'],
            ]
        );
        $user->markEmailAsVerified();
        $user->save();

        return [
            'data' => [
                'user' => new UserResource($user),
            ]
        ];
    }
}
