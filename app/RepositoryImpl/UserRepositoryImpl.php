<?php

namespace App\RepositoryImpl;

use App\Models\Patient;
use App\Models\User;
use App\Repository\UserRepository;
use Illuminate\Http\JsonResponse;

class UserRepositoryImpl implements UserRepository
{

    public function completeProfile($request): JsonResponse
    {
        try {
            $user = User::find(auth()->id());
            $patient = Patient::where('user_id', auth()->id())->first();
            if (!$user) {
                return response_json(false, null, 'User not found', 404);
            }

            $user->update([
                'user_name' => $request->user_name,
                'user_fullname' => $request->user_fullname,
                'user_phone' => $request->user_phone,
                'user_address' => $request->user_address,
                'user_date_of_birth' => $request->user_date_of_birth,
                'user_gender' => $request->user_gender,
                'is_complete_profile' => true
            ]);

            $patient->update([
                'patient_fullname' => $request->user_fullname,
                'patient_date_of_birth' => $request->user_date_of_birth,
                'patient_phone' => $request->user_phone
            ]);

            return response_json(true, $user, 'Profile updated successfully', 200);
        } catch (\Exception $error) {
            return response_json(false, null, "Update profile failed", 500);
        }
    }
}
