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

    public function getAllReservation()
    {
        // TODO: Implement getReservationByPatientId() method.
    }

    public function getReservationById($id)
    {
        // TODO: Implement Get Reservation by Id.
    }

    public function getReservationByUserId($id): JsonResponse
    {
        try {
            $reservations = Reservation::with(['patient', 'doctor', 'user'])
                ->where('user_id', $id)
                ->get()
                ->map(function ($reservation) {
                    return [
                        'id_reservation' => $reservation->id_reservation,
                        'reservation_status' => $reservation->reservation_status,
                        'reservation_insurance_type' => $reservation->reservation_insurance_type,
                        'reservation_date' => $reservation->reservation_date,
                        'patient_fullname' => $reservation->patient->patient_fullname,
                        'doctor_name' => $reservation->doctor->doctor_name,
                        'clinic_name' => $reservation->doctor->clinic->clinic_name,
                        'created_at' => $reservation->created_at,
                        'updated_at' => $reservation->updated_at
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
            $reservations = Reservation::with(['patient', 'doctor'])
                ->where('patient_id', $id)
                ->get()
                ->map(function ($reservation) {
                    return [
                        'id_reservation' => $reservation->id_reservation,
                        'reservation_status' => $reservation->reservation_status,
                        'reservation_insurance_type' => $reservation->reservation_insurance_type,
                        'reservation_date' => $reservation->reservation_date,
                        'patient_fullname' => $reservation->patient->patient_fullname,
                        'doctor_name' => $reservation->doctor->doctor_name,
                        'clinic_name' => $reservation->doctor->clinic->clinic_name,
                        'created_at' => $reservation->created_at,
                        'updated_at' => $reservation->updated_at
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

            $reservation = new Reservation();
            $reservation->id_reservation = GenerateRandomValue::generateRandomReservationId();
            $reservation->reservation_insurance_type = $request->reservation_insurance_type;
            $reservation->reservation_date = $request->reservation_date;
            $reservation->patient_id = $request->patient_id;
            $reservation->doctor_id = $request->doctor_id;
            $reservation->user_id = $request->user_id;

            DB::beginTransaction();

            $reservation->save();

            $latestQueueNumber = Queue::where('doctor_id', $request->doctor_id)
                ->max('queue_number');
            $newQueueNumber = $latestQueueNumber ? $latestQueueNumber + 1 : 1;

            $queue = Queue::create([
                'id_queue' => Uuid::uuid4(),
                'queue_number' => $newQueueNumber,
                'doctor_id' => $request->doctor_id,
            ]);

            DB::commit();

            $this->saveQueueToFirestore($queue, $reservation);

            return response_json(true, $reservation, "Reservation created successfully, queue updated", 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response_json(false, null, $e->getMessage(), 500);
        }
    }



    public function deleteReservation($id)
    {
        // TODO: Implement deleteReservation() method.
    }


    private function saveQueueToFirestore($queue, $reservation): void
    {
        try {
            $firebaseService = app()->make(\App\Services\FirebaseService::class);


            $queueData = [
                'id_queue' => $queue->id_queue,
                'queue_number' => $queue->queue_number,
                'doctor_id' => $queue->doctor_id,
                'reservation_id' => $reservation->id_reservation,
                'reservation_date' => $reservation->reservation_date,
                'status' => $reservation->reservation_status,
            ];

            $formattedData = [
                'fields' => \App\Helpers\FirestoreHelper::formatDocument($queueData),
            ];

            $firebaseService->createDocument('queue', $formattedData);
        } catch (\Exception $e) {
            dd('Failed to save queue to Firestore: ' . $e->getMessage());
        }
    }
}
