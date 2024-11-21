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

            $doctors = Doctor::with('clinic')->paginate(10);


            $transformedDoctors = collect($doctors->items())->map(function ($doctor) {
                $doctor->doctor_image = URL::to("/storage/doctor_images/{$doctor->doctor_image}");

                return [
                    'id_doctor' => $doctor->id_doctor,
                    'doctor_name' => $doctor->doctor_name,
                    'doctor_sip' => $doctor->doctor_sip,
                    'doctor_str' => $doctor->doctor_str,
                    'doctor_age' => $doctor->doctor_age,
                    'doctor_rating' => $doctor->doctor_rating,
                    'doctor_image' => $doctor->doctor_image,
                    'clinic_id' => $doctor->clinic_id,
                    'clinic_name' => $doctor->clinic->clinic_name ?? null,
                    'created_at' => $doctor->created_at,
                    'updated_at' => $doctor->updated_at,
                ];
            });


            $pagination = [
                'total' => $doctors->total(),
                'currentPage' => $doctors->currentPage(),
                'totalPage' => $doctors->lastPage(),
                'hasNext' => $doctors->hasMorePages(),
                'hasPrev' => $doctors->currentPage() > 1,
            ];

            return response_json(true, $transformedDoctors->toArray(), 'Get all doctor success', 200, $pagination);
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

    public function getAvailableDoctorsByClinicAndDate($clinicId, $date)
    {
        try {
            $dayOfWeek = date('l', strtotime($date));

            $doctors = DB::table('tb_doctor')
                ->join('tb_schedule', 'tb_doctor.id_doctor', '=', 'tb_schedule.doctor_id')
                ->where('tb_doctor.clinic_id', $clinicId)
                ->where('tb_schedule.days', $dayOfWeek)
                ->select(
                    'tb_doctor.id_doctor',
                    'tb_doctor.doctor_name',
                    'tb_doctor.doctor_sip',
                    'tb_doctor.doctor_str',
                    'tb_doctor.doctor_age',
                    'tb_doctor.doctor_rating',
                    'tb_doctor.doctor_image',
                    'tb_doctor.clinic_id',
                    'tb_schedule.start_time',
                    'tb_schedule.end_time',
                    'tb_doctor.created_at',
                    'tb_doctor.updated_at'
                )
                ->get();

            $availableDoctors = $doctors->filter(function ($doctor) use ($date) {
                $isReserved = DB::table('tb_reservation')
                    ->where('doctor_id', $doctor->id_doctor)
                    ->where('reservation_date', $date)
                    ->exists();

                return !$isReserved;
            });

            $formattedDoctors = $availableDoctors->map(function ($doctor) {
                return [
                    'id_doctor' => $doctor->id_doctor,
                    'doctor_name' => $doctor->doctor_name,
                    'doctor_sip' => $doctor->doctor_sip,
                    'doctor_str' => $doctor->doctor_str,
                    'doctor_age' => (int) $doctor->doctor_age,
                    'doctor_rating' => $doctor->doctor_rating,
                    'doctor_image' => Url::to("/storage/doctor_images/{$doctor->doctor_image}"),
                    'clinic_id' => $doctor->clinic_id,
                    'clinic_name' => $doctor->clinic_name ?? 'Default Clinic',
                    'created_at' => $doctor->created_at,
                    'updated_at' => $doctor->updated_at,
                ];
            });

            return response_json(true, $formattedDoctors, 'Available doctors fetched successfully', 200);
        } catch (\Exception $e) {
            return response_json(false, null, 'Failed to fetch available doctors', 500);
        }
    }
}
