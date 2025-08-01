<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'status',
        'phone_number',
        'avatar',
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

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    /**
     * purchasedPositions
     *
     * @return BelongsToMany
     */
    public function purchasedPositions(): BelongsToMany
    {
        return $this->belongsToMany(Position::class, 'position_user');
    }

    public function lastPendingTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->ofMany(
            ['created_at' => 'max'],
            function ($query) {
                $query->where('status', 'pending');
            }
        );
    }
}
