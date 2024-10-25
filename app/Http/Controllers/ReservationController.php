<?php

namespace App\Http\Controllers;

use App\Repository\ReservationRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReservationController extends Controller
{
    protected ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
//        $this->middleware('auth:api');
        $this->reservationRepository = $reservationRepository;
    }

    public function getAllReservation()
    {
        return $this->reservationRepository->getAllReservation();
    }

    public function getReservationById($id)
    {
        return $this->reservationRepository->getReservationById($id);
    }

    public function getReservationByPatientId($id)
    {
        return $this->reservationRepository->getReservationByPatientId($id);
    }

    public function getReservationByUserId($id)
    {
        return $this->reservationRepository->getReservationByUserId($id);
    }

    public function createReservation(Request $request)
    {
        $request->validate([
            'reservation_insurance_type' => 'required',
            'reservation_date' => 'required',
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'user_id' => 'required'
        ]);
        return $this->reservationRepository->createReservation($request);
    }

    public function deleteReservation($id)
    {
        return $this->reservationRepository->deleteReservation($id);
    }

    public function advanceFilter(Request $request)
    {
        return $this->reservationRepository->advancedFilter($request);
    }
}
