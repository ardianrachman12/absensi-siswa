<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'username',
        'password',
        'role_id',
        'remember_token'
    ];

    protected $attributes = [
        'role_id' => 2,
    ];

    protected $table = 'teachers';

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class,'role_id');
    }
    
}
