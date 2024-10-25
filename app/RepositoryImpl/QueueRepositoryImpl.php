<?php

namespace App\RepositoryImpl;

use App\Models\Queue;
use App\Repository\QueueRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class QueueRepositoryImpl implements QueueRepository
{
    public function getQueueByDoctorId($id): JsonResponse
    {
        try {
            $queue = Queue::where('doctor_id', $id)->get();
            return response_json(true, $queue, 'Get queue success', 200);
        } catch (\Exception $error) {
            return response_json(false, null, "Get queue failed", 500);
        }
    }

    public function createQueue($request): JsonResponse
    {
        try {
            $queue = new Queue();
            $queue->id_queue = Uuid::uuid4();
            $queue->queue_number = 1;
            $queue->doctor_id = $request->doctor_id;

            DB::beginTransaction();
            $queue->save();
            DB::commit();
            return response_json(true, $queue, 'Queue created successfully', 201);
        } catch (\Exception $error) {
            DB::rollBack();
            return response_json(false, null, "Failed to create queue", 500);
        }
    }

    public function updateQueue($id): JsonResponse
    {
        try {
            $queue = Queue::where('doctor_id', $id)->first();
            $queue->queue_number = $queue->queue_number + 1;

            DB::beginTransaction();
            $queue->save();
            DB::commit();
            return response_json(true, $queue, 'Queue updated successfully', 200);
        } catch (\Exception $error) {
            DB::rollBack();
            return response_json(false, null, "Failed to update queue", 500);
        }
    }

    public function resetQueue($id)
    {
        // TODO: Implement resetQueue() method.
    }
}
