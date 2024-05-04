<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homeworks';

    protected $fillable = [
        'title',
        'description',
        'enseignant_id',
        
    ];

    public function enseignants() : BelongsTo {
        return $this->belongsTo(Enseignant::class,'enseignant_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class);
    }
}
