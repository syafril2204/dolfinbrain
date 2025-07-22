<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'features',
        'is_bimbel',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_bimbel' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_packages')
            ->withTimestamps()
            ->withPivot(['expired_at', 'status']);
    }
}
