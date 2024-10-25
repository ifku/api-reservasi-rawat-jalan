<?php

namespace App\Repository;

interface ScheduleRepository {
    public function getAllSchedule();

    public function getScheduleById($id);

    public function getScheduleByDoctorId($id);

    public function createSchedule($request);

    public function deleteSchedule($id);
}
