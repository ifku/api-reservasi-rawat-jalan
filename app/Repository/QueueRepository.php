<?php

namespace App\Repository;

interface QueueRepository
{
    public function getQueueByDoctorId($id);

    public function createQueue($request);

    public function updateQueue($id);

    public function resetQueue($id);
}
