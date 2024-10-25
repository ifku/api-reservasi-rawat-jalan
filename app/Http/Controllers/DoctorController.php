<?php

namespace App\Http\Controllers;

use App\Repository\DoctorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DoctorController extends Controller
{
    protected DoctorRepository $doctorRepository;

    public function __construct(DoctorRepository $doctorRepository)
    {
        $this->doctorRepository = $doctorRepository;
    }

    public function getAllDoctor(): JsonResponse
    {
        return $this->doctorRepository->getAllDoctor();
    }

    public function getDoctorById(Request $request, $id): JsonResponse
    {
        $request->validate([
            'id' => 'required|uuid|exists:tb_doctor,id_doctor'
        ]);
        return $this->doctorRepository->getDoctorById($id);
    }

    public function createDoctor(Request $request): JsonResponse
    {
        $request->validate([
            'doctor_name' => 'required|string|max:255',
            'doctor_sip' => 'required|numeric|min:0',
            'doctor_str' => 'required|numeric|min:0',
            'doctor_age' => 'required|numeric|min:0|max:100',
            'doctor_rating' => 'required|numeric|min:0|max:5',
            'clinic_id' => 'required|uuid|exists:tb_clinic,id_clinic',
            'doctor_image' => 'required|mimes:jpg,png,jpeg'
        ]);

        return $this->doctorRepository->createDoctor($request);
    }

    public function getAllDoctorByClinicId($id): JsonResponse
    {
        return $this->doctorRepository->getAllDoctorByClinicId($id);
    }

    public function deleteDoctor(Request $request, $id): JsonResponse
    {
        $request->validate([
            'id' => 'required|uuid|exists:tb_doctor,id_doctor'
        ]);
        return $this->doctorRepository->deleteDoctor($id);
    }
}
