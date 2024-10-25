<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clinic extends Model
{
    protected $table = 'tb_clinic';
    protected $primaryKey = 'id_clinic';
    public $incrementing = false;
    protected $keyType = "uuid";

    protected $fillable = [
        'id_clinic',
        'clinic_name',
        'clinic_icon'
    ];

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'clinic_id', 'id_clinic');
    }

}
