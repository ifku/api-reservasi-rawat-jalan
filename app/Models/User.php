<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'tb_users';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = "uuid";
    protected $fillable = [
        'user_name',
        'user_fullname',
        'user_nik',
        'user_email',
        'user_phone',
        'user_gender',
        'user_address',
        'user_date_of_birth',
        'is_complete_profile',
        'refresh_token'
    ];

    protected $hidden = [
        'role_id',
        'remember_token',
    ];

    public function patient(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
