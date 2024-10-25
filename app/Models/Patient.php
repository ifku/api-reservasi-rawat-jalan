<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $table = 'tb_patient';
    protected $primaryKey = 'id_patient';
    protected $keyType = "uuid";
    public $incrementing = false;

    protected $fillable = [
        'patient_fullname',
        'patient_nik',
        'patient_date_of_birth',
        'patient_phone',
        'user_id'
    ];
    protected $hidden = [
        'patient_status_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function patientStatus(): BelongsTo
    {
        return $this->belongsTo(PatientStatus::class, 'patient_status_id', 'id_patient_status');
    }

    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class, 'patient_id', 'id_patient');
    }
}
