<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enfant extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullname',
        'image',
        'gender',
        'parent_id',
        'class_id',
    ];
public function parents() : BelongsTo {
    return $this->belongsTo(Parents::class,'parent_id');
}
public function classes() : BelongsTo {
    return $this->belongsTo(Classes::class,'class_id');
}
}
