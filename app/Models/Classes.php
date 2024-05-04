<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classes extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_de_class',
        'emploi_de_temps',
    ];
    public function  Enfants():HasMany {
        return $this->hasMany(Enfant::class,'class_id');
    }
    public function  Enseignants(){
        return $this->belongsToMany(Enseignant::class);
    }
    public function homework()
    {
        return $this->belongsToMany(Homework::class);
    }
}
