<?php

namespace App\Http\Controllers;

use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
//        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
    }

    public function completeProfile(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_fullname' => 'required|string|max:255',
            'user_address' => 'required|string|max:500',
            'user_phone' => 'required|string|max:255',
            'user_gender' => 'required|string|max:255',
            'user_date_of_birth' => 'required|date',
        ]);

        return $this->userRepository->completeProfile($request);
    }
}


/**
 * @OA\Put (
 *     path="/user/complete-profile",
 *     tags={"User"},
 *     summary="Complete user profile",
 *     description="Complete user profile",
 *     operationId="completeProfile",
 *     security={{"bearerAuth": {}}},
 *     @OA\Response(
 *         response="default",
 *         description="User profile updated successfully"
 *     ),
 *     @OA\RequestBody(
 *         description="User profile data",
 *         required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="user_name", type="string", example="Someone"),
 *         @OA\Property(property="user_fullname", type="string", example="Someone Strange"),
 *         @OA\Property(property="user_nik", type="string", example="123456789"),
 *         @OA\Property(property="user_phone", type="string", example="08123456789"),
 *         @OA\Property(property="user_gender", type="string", example="MALE"),
 *      )
 *     )
 * )
 */
