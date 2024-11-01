<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $table = 'classrooms';

    public function anggotas(): HasMany
    {
        return $this->hasMany(Anggota::class, 'class_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'class_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
    public function presences(): HasMany
    {
        return $this->hasMany(Presences::class);
    }
}
