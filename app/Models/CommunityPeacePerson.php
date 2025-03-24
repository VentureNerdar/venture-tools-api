<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPeacePerson extends Model
{
    protected $table = 'community_peace_persons';

    protected $fillable = ['name', 'email', 'phone'];

    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
