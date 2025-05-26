<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovementNotification extends Model
{
    protected $fillable = [
        'movement_id',
        'title',
        'body',
    ];
}
