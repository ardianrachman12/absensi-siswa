<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'code',
        'class_id',
        'lesson_id',
        'createdby_id',
        'role_id',
        'start_time',
        'end_time',
        'expiration_time'
    ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class,'class_id');
    }
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class,'lesson_id');
    }
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class,'createdby_id');
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class,'role_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'createdby_id');
    }
    public function presence(): HasMany
    {
        return $this->hasMany(Presence::class);
    }
    

}
