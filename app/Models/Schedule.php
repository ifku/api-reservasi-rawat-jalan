<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Schedule extends Model
{
    protected $table = 'tb_schedule';
    protected $primaryKey = 'id_schedule';
    public $incrementing = false;
    protected $keyType = "uuid";
    protected $fillable = [
        'id_schedule',
        'doctor_id',
        'days',
        'start_time',
        'end_time'
    ];

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class, 'doctor_id', 'id_doctor');
    }
}
