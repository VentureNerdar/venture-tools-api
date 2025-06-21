<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChurchMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'church_id',
        'people_group_id',
        'amount',
    ];

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function peopleGroup()
    {
        return $this->belongsTo(PeopleGroup::class);
    }
}
