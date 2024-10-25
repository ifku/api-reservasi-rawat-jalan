<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ScheduleTemplate extends Model
{
    protected $table = 'tb_schedule_template';
    protected $primaryKey = 'id_schedule_template';
    public $incrementing = false;
    protected $keyType = "uuid";

    protected $fillable = [
        'id_schedule_template',
        'doctor_id',
        'days_template',
        'start_time_template',
        'end_time_template'
    ];

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class, 'doctor_id', 'id_doctor');
    }
}
