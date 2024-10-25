<?php

namespace App\Http\Controllers;

use App\Repository\ClinicRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClinicController extends Controller
{
    protected ClinicRepository $clinicRepository;

    public function __construct(ClinicRepository $clinicRepository)
    {
//        $this->middleware('auth:api');
        $this->clinicRepository = $clinicRepository;
    }

    public function getAllClinic(): JsonResponse
    {
        return $this->clinicRepository->getAllClinic();
    }

    public function getClinicById($id): JsonResponse
    {
        return $this->clinicRepository->getClinicById($id);
    }

    public function createClinic(Request $request): JsonResponse
    {
        $request->validate([
            'clinic_name' => 'required|string|max:255|unique:tb_clinic,clinic_name',
            'clinic_icon' => 'required|mimes:svg'
        ]);
        return $this->clinicRepository->createClinic($request);
    }

    public function updateClinic(Request $request, $id): JsonResponse
    {
        $request->validate([
            'clinic_name' => 'required|string|max:255|unique:tb_clinic,clinic_name'
        ]);
        return $this->clinicRepository->updateClinic($request, $id);
    }

    public function deleteClinic($id): JsonResponse
    {
        return $this->clinicRepository->deleteClinic($id);
    }
}

