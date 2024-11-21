<?php

namespace App\RepositoryImpl;

use App\Helpers\GenerateRandomValue;
use App\Models\Queue;
use App\Models\Reservation;
use App\Repository\ReservationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ReservationRepositoryImpl implements ReservationRepository
{

    public function getAllReservation() {}

    public function getReservationById($id)
    {
        try {
            $reservations = Reservation::with(['patient', 'doctor', 'user', 'queues'])
                ->where('id_reservation', $id)
                ->get()
                ->map(function ($reservation) {
                    $queue = $reservation->queues->first();
                    return [
                        'id_reservation' => $reservation->id_reservation,
                        'reservation_status' => $reservation->reservation_status,
                        'reservation_insurance_type' => $reservation->reservation_insurance_type,
                        'reservation_date' => $reservation->reservation_date,
                        'queue_number' => $queue ? $queue->queue_number : null,
                        'patient_fullname' => $reservation->patient->patient_fullname,
                        'doctor_id' => $reservation->doctor->id_doctor,
                        'doctor_name' => $reservation->doctor->doctor_name,
                        'clinic_name' => $reservation->doctor->clinic->clinic_name,
                        'created_at' => $reservation->created_at,
                        'updated_at' => $reservation->updated_at,
                    ];
                });

            return response_json(true, $reservations, "Success get reservation by id $id", 200);
        } catch (\Exception $e) {
            return response_json(false, null, "Failed to get reservation by id $id", 500);
        }
    }

    public function getReservationByUserId($id): JsonResponse
    {
        try {
            $reservations = Reservation::with(['patient', 'doctor', 'user', 'queues'])
                ->where('user_id', $id)
                ->get()
                ->map(function ($reservation) {
                    $queue = $reservation->queues->first();
                    return [
                        'id_reservation' => $reservation->id_reservation,
                        'reservation_status' => $reservation->reservation_status,
                        'reservation_insurance_type' => $reservation->reservation_insurance_type,
                        'reservation_date' => $reservation->reservation_date,
                        'queue_number' => $queue ? $queue->queue_number : null,
                        'patient_fullname' => $reservation->patient->patient_fullname,
                        'doctor_id' => $reservation->doctor->id_doctor,
                        'doctor_name' => $reservation->doctor->doctor_name,
                        'clinic_name' => $reservation->doctor->clinic->clinic_name,
                        'created_at' => $reservation->created_at,
                        'updated_at' => $reservation->updated_at,
                    ];
                });

            return response_json(true, $reservations, "Success get reservation by user $id", 200);
        } catch (\Exception $e) {
            return response_json(false, null, "Failed to get reservation by user $id", 500);
        }
    }

    public function getReservationByPatientId($id): JsonResponse
    {
        try {
            $reservations = Reservation::with(['patient', 'doctor', 'queues'])
                ->where('patient_id', $id)
                ->get()
                ->map(function ($reservation) {
                    $queue = $reservation->queues->first();
                    return [
                        'id_reservation' => $reservation->id_reservation,
                        'reservation_status' => $reservation->reservation_status,
                        'reservation_insurance_type' => $reservation->reservation_insurance_type,
                        'reservation_date' => $reservation->reservation_date,
                        'queue_number' => $queue ? $queue->queue_number : null,
                        'patient_fullname' => $reservation->patient->patient_fullname,
                        'doctor_id' => $reservation->doctor->id_doctor,
                        'doctor_name' => $reservation->doctor->doctor_name,
                        'clinic_name' => $reservation->doctor->clinic->clinic_name,
                        'created_at' => $reservation->created_at,
                        'updated_at' => $reservation->updated_at,
                    ];
                });

            return response_json(true, $reservations, "Success get reservation by patient $id", 200);
        } catch (\Exception $e) {
            return response_json(false, null, "Failed to get reservation by patient $id", 500);
        }
    }



    public function createReservation($request): JsonResponse
    {
        try {
            $id_reservation = GenerateRandomValue::generateRandomReservationId();

            $reservation = new Reservation();
            $reservation->id_reservation = $id_reservation;
            $reservation->reservation_insurance_type = $request->reservation_insurance_type;
            $reservation->reservation_date = $request->reservation_date;
            $reservation->patient_id = $request->patient_id;
            $reservation->doctor_id = $request->doctor_id;
            $reservation->user_id = $request->user_id;

            DB::beginTransaction();

            $reservation->save();

            $latestQueueNumber = Queue::where('doctor_id', $request->doctor_id)->max('queue_number');

            $newQueueNumber = $latestQueueNumber ? $latestQueueNumber + 1 : 1;

            $queue = Queue::create([
                'id_queue' => Uuid::uuid4(),
                'queue_number' => $newQueueNumber,
                'doctor_id' => $request->doctor_id,
                'reservation_id' => $reservation->id_reservation,
            ]);

            DB::commit();

            $this->saveQueueToFirestore($queue);

            return response_json(true, $reservation, "Reservation created successfully, queue updated", 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response_json(false, null, $e->getMessage(), 500);
        }
    }

    public function deleteReservation($id) {}


    private function saveQueueToFirestore($queue): void
    {
        try {
            $firebaseService = app()->make(\App\Services\FirebaseService::class);

            $reservation = $queue->reservation;

            if (!$reservation) {
                throw new \Exception('Related reservation not found for the queue.');
            }

            $queueData = [
                'id_queue' => $queue->id_queue,
                'queue_number' => $queue->queue_number,
                'doctor_id' => $reservation->doctor_id,
                'updated_at' => now()->toDateTimeString(),
            ];

            $formattedData = [
                'fields' => \App\Helpers\FirestoreHelper::formatDocument($queueData),
            ];

            $documentId = $reservation->doctor_id;

            $firebaseService->updateOrCreateDocument('current_queue', $documentId, $formattedData);
        } catch (\Exception $e) {
            dd('Failed to save queue to Firestore: ' . $e->getMessage());
        }
    }
}
