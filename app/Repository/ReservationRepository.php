<?php

namespace App\Repository;
interface ReservationRepository
{
    public function getAllReservation();

    public function getReservationById($id);

    public function getReservationByUserId($id);

    public function getReservationByPatientId($id);

    public function createReservation($request);

    public function deleteReservation($id);

    public function advancedFilter($filters);
}
