<?php

namespace Modules\Login\Http\Services;

use Illuminate\Support\Facades\Auth;
use Modules\Login\Entities\User;

class LoginService
{
    /**
     *  Sign In a user
     *
     * @param array $requestData
     * @return bool
     */
    public function attemptLogin(array $requestData): bool
    {
        if (Auth::attempt(["email" => $requestData['email'], "password" => $requestData['password']])) {
            $user = Auth::user();
            $role = $user->role;
            if ($role == User::ROLE_BRAND || $role == User::ROLE_RETAILER) {
                Auth::logout();
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logOut(): void
    {
        Auth::logout();
    }

}
