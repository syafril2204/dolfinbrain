<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

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
        'instansi',
        'jabatan',
        'formation_id'
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
     * Relasi untuk posisi yang telah dibeli oleh pengguna.
     */
    public function purchasedPositions(): BelongsToMany
    {
        // DITAMBAHKAN: withPivot untuk mempermudah akses data 'package_type'
        return $this->belongsToMany(Position::class, 'position_user')
            ->withPivot('package_type', 'created_at');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Mengambil transaksi terakhir yang belum kedaluwarsa untuk posisi aktif pengguna.
     */
    public function lastTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->ofMany(
            ['created_at' => 'max'],
            function ($query) {
                $query
                    ->where('expired_at', '>=', now())
                    // DIPERBAIKI: Menggunakan '$this' bukan 'auth()->user()'
                    ->where('position_id', $this->position_id);
            }
        );
    }

    /**
     * Memeriksa apakah pengguna memiliki akses ke materi (telah membeli paket).
     */
    public function hasMaterialAccess(): bool
    {
        if (!$this->position_id) {
            return false;
        }

        return $this->purchasedPositions()
            ->where('position_id', $this->position_id)
            ->whereIn('package_type', ['mandiri', 'bimbingan'])
            ->exists();
    }

    /**
     * Mengambil data pembelian posisi terakhir untuk posisi yang sedang aktif.
     */
    public function latestPositionUser(): HasOne
    {
        return $this->hasOne(PositionUser::class)
            // DIPERBAIKI: Menggunakan '$this' bukan 'auth()->user()'
            ->where('position_id', $this->position_id)
            ->latestOfMany();
    }

    /**
     * Memeriksa apakah pengguna memiliki akses LMS (paket bimbingan) untuk posisi aktif.
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

    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
