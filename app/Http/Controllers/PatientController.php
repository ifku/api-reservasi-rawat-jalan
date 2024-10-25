<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Repository\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PatientController extends Controller
{
    protected PatientRepository $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
//        $this->middleware('auth:api');
        $this->patientRepository = $patientRepository;
    }

    public function createPatient(Request $request)
    {
        $request->validate([
            'patient_name' => 'required',
            'patient_nik' => 'required',
            'patient_date_of_birth' => 'required',
            'patient_age' => 'required',
            'user_id' => 'required',
            'patient_status_id' => 'required'
        ]);
        return $this->patientRepository->createPatient($request);
    }

    public function getPatientByUserId($id)
    {
        return $this->patientRepository->getPatientByUserId($id);
    }
}
