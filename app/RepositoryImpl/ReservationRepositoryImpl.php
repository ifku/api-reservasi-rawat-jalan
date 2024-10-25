<?php

namespace App\RepositoryImpl;

use App\Helpers\GenerateRandomValue;
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
            DB::commit();
            return response_json(true, $reservation, "Reservation created successfully", 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response_json(false, null, $e->getMessage(), 500);
        }
    }

    public function deleteReservation($id)
    {
        // TODO: Implement deleteReservation() method.
    }

    public function advancedFilter($filters): JsonResponse
    {
        try {
            $query = Reservation::with(['patient', 'doctor', 'user']);

            if (isset($filters['filters'])) {
                foreach ($filters['filters'] as $filter) {
                    $field = $filter['field'];
                    $operator = $filter['operator'];
                    $value = $filter['value'];

                    switch ($operator) {
                        case 'between':
                            $query->whereBetween($field, $value);
                            break;
                        case '=':
                            $query->where($field, '=', $value);
                            break;
                        case 'contains':
                            $query->where($field, 'like', '%' . $value . '%');
                            break;
                        case '<':
                            $query->where($field, '<', $value);
                            break;
                        case '>':
                            $query->where($field, '>', $value);
                            break;
                    }
                }
            }

            if (isset($filters['or_filters'])) {
                $query->where(function ($q) use ($filters) {
                    foreach ($filters['or_filters'] as $filter) {
                        $field = $filter['field'];
                        $operator = $filter['operator'];
                        $value = $filter['value'];

                        switch ($operator) {
                            case 'between':
                                $q->orWhereBetween($field, $value);
                                break;
                            case '=':
                                $q->orWhere($field, '=', $value);
                                break;
                            case 'contains':
                                $q->orWhere($field, 'like', '%' . $value . '%');
                                break;
                            case '<':
                                $q->orWhere($field, '<', $value);
                                break;
                            case '>':
                                $q->orWhere($field, '>', $value);
                                break;
                        }
                    }
                });
            }

            $reservations = $query->get()->map(function ($reservation) {
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

            return response_json(true, $reservations, 'Successfully filtered reservations', 200);
        } catch (\Exception $e) {
            return response_json(false, null, 'Failed to filter reservations: ' . $e->getMessage(), 500);
        }
    }
}
