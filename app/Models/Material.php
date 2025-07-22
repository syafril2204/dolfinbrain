<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'file_size',
        'file_type',
    ];

    // Relasi many-to-many ke Position
    // Menentukan materi ini untuk jabatan apa saja
    public function positions()
    {
        return $this->belongsToMany(Position::class, 'material_position');
    }
}
