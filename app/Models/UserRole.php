<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'label',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'deleted_at'            => 'immutable_datetime:d M Y H:i:s',
            'created_at'            => 'immutable_datetime:d M Y H:i:s',
            'updated_at'            => 'immutable_datetime:d M Y H:i:s',
        ];
    }
}
