<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PositionUser extends Model
{
    use HasFactory;

    protected $table = 'position_user';
    protected $guarded = [''];
}
