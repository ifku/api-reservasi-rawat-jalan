<?php

namespace App\Http\Controllers;

use App\Repository\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class AuthController extends Controller
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
        $this->middleware('auth:api', ['except' => ['signUp', 'signIn', 'sendOtp']]);
    }

    public function signUp(Request $request)
    {
        $request->validate([
            'user_email' => 'required|email|max:255|unique:tb_users,user_email',
            'user_nik' => 'required|numeric|unique:tb_users,user_nik'
        ]);

        return $this->authRepository->signUp($request);
    }

    public function signIn(Request $request)
    {
        $request->validate([
            'user_email' => 'required | email | max:255',
            'user_otp' => 'required | numeric',
        ]);

        return $this->authRepository->signIn($request);
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'user_email' => 'required|email|max:255',
        ]);

        return $this->authRepository->sendOtp($request);
    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'id_user' => 'required'
        ]);
        return $this->authRepository->refreshToken($request);
    }

    public function signOut(Request $request)
    {
        return $this->authRepository->signOut($request);
    }
}
