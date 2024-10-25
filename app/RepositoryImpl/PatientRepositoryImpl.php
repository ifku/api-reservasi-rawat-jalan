<?php

namespace App\RepositoryImpl;

use App\Models\Patient;
use App\Repository\PatientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PatientRepositoryImpl implements PatientRepository
{

    public function createPatient($request): JsonResponse
    {
        try {
            $patient = new Patient();
            $patient->id_patient = Uuid::uuid4();
            $patient->patient_name = $request->patient_name;
            $patient->patient_nik = $request->patient_nik;
            $patient->patient_date_of_birth = $request->patient_date_of_birth;
            $patient->patient_age = $request->patient_age;
            $patient->user_id = $request->user_id;
            $patient->patient_status_id = $request->patient_status_id;

            DB::BeginTransaction();
            $patient->save();
            DB::commit();
            return response_json(true, $patient, 'Patient created successfully', 201);
        } catch (\Exception $error) {
            DB::rollBack();
            return response_json(false, null, "Failed to create patient", 500);
        }
    }

    public function getPatientByUserId($id): JsonResponse
    {
        try {
            $patients = Patient::where('user_id', $id)
                ->with('patientStatus')
                ->get()
                ->map(function ($patient) {
                    return [
                        'id_patient' => $patient->id_patient,
                        'patient_fullname' => $patient->patient_fullname,
                        'patient_nik' => $patient->patient_nik,
                        'patient_date_of_birth' => $patient->patient_date_of_birth,
                        'patient_phone' => $patient->patient_phone,
                        'patient_status' => $patient->patientStatus->patient_status_name,
                        'created_at' => $patient->created_at,
                        'updated_at' => $patient->updated_at
                    ];
                });

            if ($patients->isNotEmpty()) {
                return response_json(true, $patients, 'Patients retrieved successfully', 200);
            } else {
                return response_json(false, null, 'No patients found for the given user ID', 404);
            }
        } catch (\Exception $error) {
            return response_json(false, "Failed to retrieve patients data", 500);
        }
    }
}
