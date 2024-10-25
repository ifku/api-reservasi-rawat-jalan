<?php

namespace App\Repository;
interface PatientRepository
{
    public function createPatient($request);

    public function getPatientByUserId($id);
}
