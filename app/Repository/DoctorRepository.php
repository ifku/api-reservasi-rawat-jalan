<?php

namespace App\Repository;

interface DoctorRepository
{
    public function getAllDoctor();

    public function getDoctorById($id);

    public function getAllDoctorByClinicId($id);
    
    public function getAvailableDoctorsByClinicAndDate($clinicId, $date);

    public function createDoctor($request);

    public function deleteDoctor($id);
}
