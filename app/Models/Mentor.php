<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position_id',
        'photo',
        'education',
        'motto',
        'description',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
