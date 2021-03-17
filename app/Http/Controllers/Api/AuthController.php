<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;

    public function login(LoginRequest $request)
    {
        if (!Auth::attempt([
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ])) {
            return $this->error('Invalid Credentials', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken($request->device_name)->plainTextToken,
        ]);
    }

    public function signUp(SignUpRequest $request)
    {
        $user = User::create();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return $this->success(['token' => $user->createToken($request->device_name)]);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return [
            'message' => 'Tokens Revoked',
        ];
    }
}
