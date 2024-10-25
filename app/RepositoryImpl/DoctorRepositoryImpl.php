<?php

namespace App\RepositoryImpl;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Repository\DoctorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Helpers\ImageUploadHelper;
use Ramsey\Uuid\Nonstandard\Uuid;

class DoctorRepositoryImpl implements DoctorRepository
{
    public function getAllDoctor(): JsonResponse
    {
        try {
            $doctors = Doctor::all();
            $doctors = $doctors->map(function ($doctor) {
                $doctor->doctor_image = URL::to("/storage/doctor_images/{$doctor->doctor_image}");
                return $doctor;
            });
            return response_json(true, $doctors, 'Get all doctor success', 200);
        } catch (\Exception $error) {
            return response_json(false, null, 'Failed to fetch data', 500);
        }
    }

    public function getDoctorById($id): JsonResponse
    {
        try {
            $doctor = Doctor::find($id);

            $doctor->doctor_image = URL::to("/storage/doctor_images/{$doctor->doctor_image}");
            return response_json(true, $doctor, 'Get doctor by id success', 200);
        } catch (\Exception $error) {
            return response_json(false, null, 'Failed to fetch data', 500);
        }
    }

    public function getAllDoctorByClinicId($id): JsonResponse
    {
        try {
            $doctors = Doctor::whereHas('clinic', function ($query) use ($id) {
                $query->where('id_clinic', $id);
            })->get();

            $clinicName = Clinic::where('id_clinic', $id)->value('clinic_name');

            $doctors = $doctors->map(function ($doctor) use ($clinicName) {
                $doctor->clinic_name = $clinicName;
                $doctor->doctor_image = URL::to("/storage/doctor_images/{$doctor->doctor_image}");
                return $doctor;
            });
            return response_json(true, $doctors, 'Get all doctor by clinic id success', 200);
        } catch (\Exception $error) {
            return response_json(false, null, 'Failed to get doctor by clinic id', 500);
        }
    }


    public function createDoctor($request): JsonResponse
    {
        try {
            $doctor = new Doctor;
            $id = Uuid::uuid4();
            $doctor->id_doctor = $id;
            $doctor->doctor_name = $request->input('doctor_name');
            $doctor->doctor_sip = $request->input('doctor_sip');
            $doctor->doctor_str = $request->input('doctor_str');
            $doctor->doctor_age = $request->input('doctor_age');
            $doctor->doctor_rating = $request->input('doctor_rating');
            $doctor->clinic_id = $request->input('clinic_id');
            $imageUrl = ImageUploadHelper::upload($request->file('doctor_image'), 'doctor_images', ['jpg', 'png', 'jpeg']);
            $doctor->doctor_image = $imageUrl;

            DB::beginTransaction();
            $doctor->save();
            DB::commit();
            return response_json(true, $doctor, 'Get all doctor by clinic id success', 200);
        } catch (\Exception $error) {
            DB::rollBack();
            return response_json(false, null, 'Failed to fetch data', 500);
        }
    }

    public function deleteDoctor($id): JsonResponse
    {
        try {
            $doctor = Doctor::find($id);
            $doctor->delete();
            return response_json(true, $doctor, 'Doctor deleted', 200);

        } catch (\Exception $error) {
            return response_json(false, null, 'Failed to delete data', 500);
        }
    }
}
