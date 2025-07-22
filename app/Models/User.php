<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles; // Import trait

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens; // Gunakan trait

    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'date_of_birth',
        'domicile',
        'phone_number',
        'avatar',
        'formation_id',
        'position_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'password' => 'hashed',
    ];
}
