<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaithMilestone extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'icon',
    ];
}
