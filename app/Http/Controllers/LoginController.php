<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * @param LoginRequest $loginRequestData
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $loginRequestData)
    {
        $user = new User();
        $userData = $user->where('email', $loginRequestData->email)
            ->where('password',Hash::check('plain-text', $loginRequestData->password))->first();

        if ($userData) {
            return response()->json([
                'firstName' => $userData->first_name,
                'lastName' => $userData->last_name,
                'address' => $userData->address,
                'postcode' => $userData->postcode,
            ]);
        }

        return response()->json([
            'login' => false,
            'data' => 'User not found'
        ]);
    }
}
