<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeopleGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        // 'translations',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
