<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Authenticate an user.
     *
     * @param Request $request
     *
     * @see ProfileController::getFullInfoUser()
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:191',
            'password' => 'required|between:6,191'
        ]);

        $token = JWTAuth::attempt($request->only('email', 'password'));

        if ($token) {
            $info = ProfileController::getFullInfoUser();
            $info['token'] = $token;

            return response()->json($info);
        }

        return response()->json(['message' => 'Email або пароль не існує.'], 401);
    }

    /**
     * Refresh token to user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken()
    {
        $token = JWTAuth::getToken();

        if (! $token) {
            return response()->json(['message' => 'Токен не дійсний'], 401);
        }

        return response()->json(['token' => JWTAuth::refresh($token)]);
    }

    /**
     * Logout user.
     *
     * @return void
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
