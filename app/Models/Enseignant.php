<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enseignant extends Authenticatable implements JWTSubject 
{
    use HasFactory ,Notifiable,HasApiTokens;



    protected $fillable = [
        'fullname',
        'email',
        'telephone',
        'image',
        'gender',
        'role',
        'password',
    ];

    protected $gardes = 'enseignants';
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
    public function  matieres(){
        return $this->belongsToMany(Matiere::class);
    }
    public function  classes(){
        return $this->belongsToMany(Classes::class);
    }
    public function  homeworks():HasMany {
        return $this->hasMany(Homework::class);
    }
}