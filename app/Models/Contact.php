<?php

namespace App\Models;

use App\Enums\AgeGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        // 'contact_status_id',
        'faith_status_id',
        'assigned_to',
        'coached_by',
        'name',
        'nickname',
        'gender',
        'age',

        'baptism_date',
        'baptized_by',
        'baptized_by_name',
        'baptized',

        'current_prayers',
        'is_active',
    ];

    protected $dates = [
        // 'baptism_date',
    ];

    protected $casts = [
        // 'baptism_date' => 'date',
        // 'baptism_date' => 'timestamp',
        'is_active' => 'boolean',
        'age' => AgeGroup::class,
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'contact_status_id');
    }

    public function faithStatus()
    {
        return $this->belongsTo(Status::class, 'faith_status_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function coachedBy()
    {
        return $this->belongsTo(Contact::class, 'coached_by');
    }

    public function faithMilestones()
    {
        return $this->belongsToMany(FaithMilestone::class);
    }

    public function peopleGroup()
    {
        return $this->belongsToMany(PeopleGroup::class, 'contact_people_group')
            ->withTimestamps();
    }

    public function contactCommunicationPlatforms()
    {
        // return $this->belongsToMany(ContactCommunicationPlatform::class, 'contact_communication_platform');
        return $this->hasMany(ContactCommunicationPlatform::class);
    }

    public function baptizedBy()
    {
        return $this->belongsTo(Contact::class, 'baptized_by');
    }

    public function baptized()
    {
        // return $this->hasMany(Contact::class, 'baptized_by')->where('id', '!=', $this->id);
        return $this->hasMany(Contact::class, 'baptized_by');
    }
}
