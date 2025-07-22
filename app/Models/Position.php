<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['formation_id', 'name', 'slug'];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
