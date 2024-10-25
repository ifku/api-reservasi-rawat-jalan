<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $table = "tb_reservation";
    protected $primaryKey = "id_reservation";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'id_reservation',
        'reservation_status',
        'reservation_insurance_type',
        'reservation_date',
        'patient_id',
        'doctor_id',
        'user_id'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id_doctor');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id_patient');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

}
