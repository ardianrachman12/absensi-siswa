<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'codeName',
        'class_id',
    ];

    protected $table = 'lessons';

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class,'class_id');
    }
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

}
