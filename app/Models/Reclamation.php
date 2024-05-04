<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Parent_;

class Reclamation extends Model
{
    use HasFactory;
    protected $fillable = [
        'statue',
        'title',
        'description',
        'response',
        'parent_id',
    ];

    public function Parents(){
        return $this->belongsTo(Parents::class,'parent_id');
    }
}
