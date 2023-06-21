<?php

namespace Modules\Login\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginService
{
    /**
     * Sign In a user
     *
     * @param array $requestData
     * @return array
     */
    public function attemptLogin(array $requestData): array
    {
        if (Auth::attempt(["email" => $requestData['email'], "password" => $requestData['password']])) {
            $user = Auth::user();
            $role = $user->role;
            if ($role == 'brand' || $role == 'retailer') {
                Auth::logout();
                return [
                    'res' => false,
                    'msg' => 'Invalid credentials',
                    'data' => ''
                ];
            } else {
                return [
                    'res' => true,
                    'msg' => '',
                    'data' => $user
                ];
            }

        } else {
            return [
                'res' => false,
                'msg' => 'Invalid credentials',
                'data' => ''
            ];
        }

    }

    public function logOut()
    {
        Auth::logout();
    }

}
