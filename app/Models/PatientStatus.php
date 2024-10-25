<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PatientStatus extends Model
{
    protected $table = 'tb_patient_status';
    protected $primaryKey = 'id_patient_status';
    public $incrementing = false;
    protected $keyType = "uuid";

    protected $fillable = [
        'patient_status_name'
    ];

    public function patient(): HasMany
    {
        return $this->hasMany(Patient::class, 'patient_status_id', 'id_patient_status');
    }
}
