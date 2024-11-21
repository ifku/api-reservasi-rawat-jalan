<?php

namespace App\Http\Controllers;

use App\Repository\QueueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QueueController extends Controller
{
    private QueueRepository $queueRepository;

    public function __construct(QueueRepository $queueRepository)
    {
//        $this->middleware('auth:api');
        $this->queueRepository = $queueRepository;
    }

    public function getQueueByDoctorId($id): JsonResponse
    {
        $id->validate([
            'doctor_id' => 'required|uuid'
        ]);
        return $this->queueRepository->getQueueByDoctorId($id);
    }

    public function updateQueue($id): JsonResponse
    {
        try {
            $queue = $this->queueRepository->updateQueue($id);

            if (!$queue) {
                return response_json(false, null, 'Queue not found', 404);
            }
            return response_json(true, $queue, 'Queue has been updated', 200);
        } catch (\Exception $error) {
            return response_json(false, $error, 'Failed to update queue', 500);
        }
    }
}
