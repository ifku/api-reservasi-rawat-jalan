<?php

namespace App\Repository;

interface ClinicRepository
{
    public function getAllClinic();

    public function getClinicById($id);

    public function createClinic($request);

    public function updateClinic($request, $id);

    public function deleteClinic($id);
}
