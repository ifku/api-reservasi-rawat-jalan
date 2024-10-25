<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    protected $table = 'tb_doctor';
    protected $primaryKey = 'id_doctor';
    protected $keyType = "uuid";
    public $incrementing = false;

    protected $fillable = [
        'id_doctor',
        'doctor_name',
        'doctor_sip',
        'doctor_str',
        'doctor_age',
        'doctor_rating',
        'doctor_image',
        'clinic_id'
    ];

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id', 'id_clinic');
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function scheduleTemplate(): BelongsTo
    {
        return $this->belongsTo(ScheduleTemplate::class);
    }


    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class, 'doctor_id', 'id_doctor');
    }
}
