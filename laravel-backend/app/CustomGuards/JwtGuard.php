<?php

namespace App\Guards;


use App\CustomGuards\JwtHelper;
use Carbon\Carbon;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class JwtGuard implements Guard
{
    use GuardHelpers;

    protected $user = null;

    public function __construct(UserProvider $provider)
    {
        $this->provider = $provider;
    }

    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        if (request()->bearerToken() && $user = $this->validate(['jwt' => request()->bearerToken()])) {
            return $this->user = $user;
        }
    }

    public function validate(array $credentials = []): bool | Authenticatable | JsonResponse
    {
        if (empty($credentials['jwt'])) {
            return false;
        }

        try {
            $decoded = JwtHelper::decodeToken($credentials['jwt']);

            if($decoded->exp < Carbon::now()->timestamp){
                return false;
            }

            // You may perform additional validation here
            return $this->user = $this->provider->retrieveById($decoded->id);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function attempt()
    {
        $user = $this->user();
        if($user){

            Auth::guard('localAuth')->login($user);
            return true;
        }
        return false;
    }
}

