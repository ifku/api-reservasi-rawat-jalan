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
        'doctor_id'
    ];

    protected $hidden = [
      'doctor_id'
    ];

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class, 'id_doctor', 'doctor_id');
    }
}
