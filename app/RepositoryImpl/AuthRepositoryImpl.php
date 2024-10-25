<?php

namespace App\RepositoryImpl;

use App\Mail\OtpMail;
use App\Models\Patient;
use App\Models\User;
use App\Repository\AuthRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

class AuthRepositoryImpl implements AuthRepository
{

    public function signUp($request): JsonResponse
    {
        $user_id = Uuid::uuid4();
        try {
            $user = new User;
            $user->id_user = $user_id;
            $user->user_email = $request->user_email;
            $user->user_nik = $request->user_nik;
            $user->save();

            $patient = new Patient;
            $patient->id_patient = Uuid::uuid4();
            $patient->patient_nik = $request->user_nik;
            $patient->user_id = $user_id;
            $patient->patient_status_id = "31976ae8-8548-4d8e-a9ae-77c54ce21693";
            $patient->save();

            $otp = $this->generateOtp($request->user_email);

            $response = [
                'user' => $user,
                'otp' => $otp['otp'],
                'expiration_time' => $otp['expiration_time'],
            ];

            return response_json(true, $response, 'User registered', 201);
        } catch (\Exception $error) {
            return response_json(false, null, "Create user failed", 500);
        }
    }

    public function signIn($request): JsonResponse
    {
        try {

            $credentials = $request->only('user_email');
            $user = User::where('user_email', $credentials['user_email'])->first();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $cacheKey = 'otp_' . $credentials['user_email'];
            $cachedOtp = Cache::get($cacheKey);

            if (!$cachedOtp || $cachedOtp != $request->input('user_otp')) {
                return response()->json(['error' => 'Invalid OTP'], 401);
            }

            $token = auth('api')->login($user);
            if (!$token) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            Cache::forget($cacheKey);

            $payloads = [
                'access_token' => $token,
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => $user,
            ];

            return response_json(true, $payloads, "User logged in", 200);
        } catch (\Exception $error) {
            return response_json(false, null, "Failed to log in", 500);
        }
    }

    public function sendOtp($request): JsonResponse
    {
        try {
            $user = User::where('user_email', $request->user_email)->first();
            if (!$user) {
                return response_json(false, null, 'User not found', 404);
            }

            $otp = $this->generateOtp($request->user_email);

            return response_json(true, $otp, 'One Time Password (OTP) sent', 200);
        } catch (\Exception $error) {
            return response_json(false, null, "Failed to send One Time Password (OTP)", 500);
        }
    }

    public function refreshToken($request): JsonResponse
    {
        try {
            $user = $request->id_user;
            $token = auth('api')->claims(['sub' => $user])->refresh();
            if (!$token) {
                return response_json(false, null, "Failed to refresh token", 500);
            }
            if (!$user) {
                return response_json(false, null, "User not found", 404);
            }
            $payloads = [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
            ];
            return response_json(true, $payloads, 'Token refreshed successfully', 200);
        } catch (\Exception $error) {
            return response_json(false, null, "Failed to refresh token", 500);
        }
    }

    public function signOut($request): JsonResponse
    {
        try {
            $user = auth('api')->user();
            if ($user) {
                Cache::delete('otp_' . $user->user_email);
            }

            Auth::logout();

            return response_json(true, null, 'User logged out', 200);
        } catch (\Exception $error) {
            return response_json(false, null, "Failed to logout", 500);
        }
    }

    public function generateOtp($userEmail)
    {
        $otp = rand(10000, 99999);

        $cacheKey = 'otp_' . $userEmail;
        $expirationTime = 60 * 5;
        Cache::put($cacheKey, $otp, $expirationTime);

        //        Mail::to($userEmail)->send(new OtpMail($otp, $userEmail));

        return [
            'otp' => $otp,
            'expiration_time' => $expirationTime,
        ];
    }
}
