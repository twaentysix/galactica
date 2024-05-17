<?php

namespace App\Http\Controllers;

use App\Guards\JwtHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\ConfirmationEmail;
use App\Models\User;
use Filament\Pages\Auth\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{
    public function authenticate (LoginRequest $request)
    {
        $credentials = $request->validated();
        if(Auth::guard('localAuth')->attempt($credentials)){
            $user = Auth::guard('localAuth')->user();
            if(!$user->hasVerifiedEmail()){
                return response()->json(Controller::getApiErrorMessage("Your account email is not confirmed", 403), 403);
            }
            $token = JwtHelper::generateToken($user);
            return response()->json(['jwt' => $token, 'user' => new UserResource($user)]);
        }
        return response()->json(Controller::getApiErrorMessage("Invalid credentials", 403), 403);
    }

    public function register(RegisterRequest $request) {
        $data = request()->post();
        if(!$data){
            return response()->json(Controller::getApiErrorMessage("Missing data", 403),403);
        }

        $data = $request->validated();
        $user = User::where('name', '=', $data['name'])->first();
        if($user){
            return response()->json(Controller::getApiErrorMessage("Username already taken.",403),403);
        }

        $user = User::where('email', '=', $data['email'])->first();
        if($user){
            return response()->json(Controller::getApiErrorMessage("Email already taken.",403),403);
        }

        // TODO send email on verification
        $referralCode = Str::uuid();
        $user = User::create(
            [
                'name' => $data['name'],
                'password' => $data['password'],
                'email' => $data['email'],
                'referral_code' => $referralCode,
            ]
        );
        $user->save();

        Mail::to($data['email'])->send(new ConfirmationEmail($referralCode));

        return [
            'data' => [
                'user' => new UserResource($user),
            ]
        ];
    }

    public function confirmEmail ($referralCode) {
        $user = User::where('referral_code', '=', $referralCode)->first();
        if($user){
            $user->markEmailAsVerified();
            return view('confirm_email', ['confirmed' => true]);
        }
        return view('confirm_email', ['confirmed' => false]);
    }
}
