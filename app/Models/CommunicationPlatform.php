<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunicationPlatform extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_communication_platform')
            ->withPivot('value')
            ->withTimestamps();
    }
}
