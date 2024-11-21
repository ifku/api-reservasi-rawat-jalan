<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Queue extends Model
{
    protected $table = 'tb_queue';
    protected $primaryKey = 'id_queue';
    public $incrementing = false;
    protected $keyType = "uuid";
    protected $fillable = [
        'id_queue',
        'queue_number',
        'doctor_id',
        'reservation_id'
    ];

    protected $hidden = [
        'reservation_id'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id_doctor');
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class, 'reservation_id', 'id_reservation');
    }
}
