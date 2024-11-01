<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presence extends Model
{
    use HasFactory;
    protected $guarded =[
        'id'
    ];

    
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class,'inputby_id');
    }
    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class,'attendance_id');
    }
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class,'class_id');
    }
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class,'lesson_id');
    }
    

}
