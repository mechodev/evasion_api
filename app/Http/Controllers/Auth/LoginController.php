<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $loginData = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required']
        ]);

        if ($loginData->fails()) {
            return response()->json([
                'success' => false,
                'hasError' => true,
                'errors' => $loginData->errors()->all(),
            ]);
        } else {

            if (!Auth::attempt($request->all())) {
                return response([
                    'message' => 'Login or password incorrect',
                    'success' => false,
                    'hasError' => true,
                ]);
            } else {

                $accessToken = Auth::user()->createToken('authToken')->accessToken;

                return response()->json([
                    'success' => true,
                    'user' => Auth::user(),
                    'access_token' => $accessToken
                ]);
            }
        }
    }
}
