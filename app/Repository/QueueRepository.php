<?php

namespace App\Repository;

interface QueueRepository
{
    public function getQueueByDoctorId($id);

    public function updateQueue($id);

    public function resetQueue($id);
}
