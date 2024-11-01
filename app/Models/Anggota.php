<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'username',
        'password',
        'class_id',
        'role_id',
        'remember_token'
    ];
    
    protected $attributes = [
        'role_id' => 3,
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $table = 'anggotas';

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class,'class_id');
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class,'role_id');
    }
    public function presences(): HasMany
    {
        return $this->hasMany(Presence::class);
    }
}
