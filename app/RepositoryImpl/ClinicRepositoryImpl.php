<?php

namespace App\RepositoryImpl;

use App\Helpers\ImageUploadHelper;
use App\Models\Clinic;
use App\Repository\ClinicRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Ramsey\Uuid\Uuid;

class ClinicRepositoryImpl implements ClinicRepository
{
    public function getAllClinic(): JsonResponse
    {
        try {
            $clinics = Clinic::all();
            $clinics = $clinics->map(function ($clinic) {
                $clinic->clinic_icon = URL::to("/storage/clinic_icon/{$clinic->clinic_icon}");
                return $clinic;
            });

            return response_json(true, $clinics, 'Get all clinic success', 200);
        } catch (\Exception $error) {
            return response_json(false, $error, 'Failed to get all clinic', 500);
        }
    }

    public function getClinicById($id): JsonResponse
    {
        try {
            $clinic = Clinic::find($id);

            $clinic->clinic_icon = URL::to("/storage/clinic_icon/{$clinic->clinic_icon}");
            return response_json(true, $clinic, 'Get clinic by id success', 200);
        } catch (\Exception $error) {
            return response_json(false, $error, 'Failed to get clinic by id', 500);
        }
    }

    public function createClinic($request): JsonResponse
    {
        try {
            $clinic = new Clinic;
            $id = Uuid::uuid4();
            $clinic->id_clinic = $id;
            $clinic->clinic_name = $request->input('clinic_name');
            $iconUrl = ImageUploadHelper::upload($request->file('clinic_icon'), 'clinic_icon', ['svg']);
            $clinic->clinic_icon = $iconUrl;

            DB::beginTransaction();
            $clinic->save();
            DB::commit();
            return response_json(true, $clinic, 'Clinic has been created', 201);
        } catch (\Exception $error) {
            DB::rollBack();
            return response_json(false, $error, 'Failed to create clinic', 500);
        }
    }

    public function updateClinic($request, $id): JsonResponse
    {
        try {
            $clinic = Clinic::find($id);
            $clinic->clinic_name = $request->input('clinic_name');

            DB::beginTransaction();
            $clinic->save();
            DB::commit();
            return response_json(true, $clinic, 'Clinic has been updated', 200);
        } catch (\Exception $error) {
            DB::rollBack();
            return response_json(false, $error, 'Failed to update clinic', 500);
        }
    }

    public function deleteClinic($id): JsonResponse
    {
        try {
            $clinic = Clinic::find($id);

            DB::beginTransaction();
            $clinic->delete();
            DB::commit();
            return response_json(true, $clinic, 'Clinic has been deleted', 200);
        } catch (\Exception $error) {
            DB::rollBack();
            return response_json(false, $error, 'Failed to delete clinic', 500);
        }
    }
}
