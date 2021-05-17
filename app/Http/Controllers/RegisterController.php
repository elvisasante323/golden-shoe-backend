<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $requestData
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $requestData)
    {
        $user = User::create([
            'first_name' => $requestData->first_name,
            'last_name' => $requestData->last_name,
            'date_of_birth' => $requestData->date_of_birth,
            'address' => $requestData->address,
            'postcode' => $requestData->postcode,
            'mobile_number' => $requestData->mobile_number,
            'email' => $requestData->email,
            'password' => Hash::make($requestData->password)
        ]);

        $user->save();

        return response()->json([
            'registration' => true,
            'message' => 'Please login now'
        ]);
    }
}
