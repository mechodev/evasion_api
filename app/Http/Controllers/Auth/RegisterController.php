<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;



class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validatedData =  Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'success' => false,
                'hasError' => true,
                'errors' => $validatedData->errors()->all(),
            ]);
        } else {

            $request['password'] = Hash::make($request->password);
            $user = User::create($request->all());

            Auth::login($user);

            $accessToken = $user->createToken('authToken')->accessToken;
            return response()->json([
                'user' => $user,
                'access_token' => $accessToken,
                'success' => true,
                'message' => 'Inscription successfully done'
            ]);
        }
    }
}
