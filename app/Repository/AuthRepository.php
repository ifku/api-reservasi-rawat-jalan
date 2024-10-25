<?php
namespace App\Repository;
interface AuthRepository
{
    public function signUp($request);
    public function signIn($request);
    public function sendOtp($request);
    public function refreshToken($request);
    public function signOut($request);
}
