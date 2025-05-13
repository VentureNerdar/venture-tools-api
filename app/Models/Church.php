<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Church extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'is_active',
        'assigned_to',
        'name',
        'description',
        'location_longitude',
        'location_latitude',
        'google_location_data',
        'founded_at',
        'phone_number',
        'website',
        'denomination_id',
        'is_visited',
        'parent_church_id',
        'current_prayers',
        'church_members_count',
        'confession_of_faith_count',
        'baptism_count',
        'community_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_visited' => 'boolean',
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function denomination()
    {
        return $this->belongsTo(Denomination::class);
    }

    public function parentChurch()
    {
        return $this->belongsTo(Church::class, 'parent_church_id');
    }

    public function churchPlanters()
    {
        // return $this->belongsToMany(User::class, 'church_planters');

        // return $this->belongsToMany(User::class, 'church_planters', 'id', 'id', 'user_id', 'id');
        return $this->hasMany(ChurchPlanter::class);
    }

    public function churchLeaders()
    {
        return $this->hasMany(ChurchLeader::class);
    }

    public function peopleGroup()
    {
        return $this->belongsToMany(PeopleGroup::class, 'church_people_group')
            ->withTimestamps();
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
