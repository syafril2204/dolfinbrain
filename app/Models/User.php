<?php

namespace App\Models;

use Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles; // Import trait

class User extends Authenticatable implements MustVerifyEmail
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

    public function lastTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->ofMany(
            ['created_at' => 'max'],
            function ($query) {
                $query
                    ->where('expired_at', '>=', now())
                    ->where('position_id', auth()->user()->position_id);
            }
        );
    }

    /**
     * positionUser
     *
     * @return HasMany
     */
    public function latestPositionUser(): HasOne
    {
        return $this->hasOne(PositionUser::class)
            ->where('position_id', auth()->user()->position_id)
            ->latestOfMany();
    }

    /**
     * hasLmsAccess
     *
     * @return bool
     */
    public function hasLmsAccess(): bool
    {
        if (!$this->position_id) {
            return false;
        }

        return $this->purchasedPositions()
            ->where('position_id', $this->position_id)
            ->where('package_type', 'bimbingan')
            ->exists();
    }
}
