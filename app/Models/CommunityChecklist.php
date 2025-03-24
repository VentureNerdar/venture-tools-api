<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityChecklist extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
}
