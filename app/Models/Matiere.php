<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;
    protected $fillable = [
        'codematiere',
        'nommatiere'
    ];
    public function Enseignant(){
        //matiere - enseignant
        return $this->belongsToMany(Enseignant::class)->withTimestamps();
    }
}
