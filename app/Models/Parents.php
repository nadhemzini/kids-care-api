<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Parents extends Authenticatable implements JWTSubject 
{
    use HasFactory ,Notifiable,HasApiTokens;



    protected $fillable = [
        'fullname',
        'image',
        'cin',
        'telephone',
        'email',
        'ville',
        'gender',
        'codepostal',
        'password',
    ];

    protected $gardes = 'parents';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
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
    public function  Enfants():HasMany {
        return $this->hasMany(Enfant::class);
    }
    public function  Reclamtions():HasMany {
        return $this->hasMany(Reclamation::class);
    }
}
