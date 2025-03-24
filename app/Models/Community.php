<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Community extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'location_longitude',
        'location_latitude',
        'conducted_survey_of_community_needs',
        'community_needs_1',
        'community_needs_2',
        'community_needs_3',
        'community_needs_4',
        'community_needs_5',
    ];

    protected $casts = [
        'conducted_survey_of_community_needs' => 'boolean',
    ];

    public function peacePersons()
    {
        return $this->hasMany(CommunityPeacePerson::class, 'community_id');
    }

    public function committees()
    {
        return $this->hasMany(CommunityCommittee::class);
    }

    public function checklists()
    {
        return $this->belongsToMany(CommunityChecklist::class);
    }

    /*
    public function churchPlanters()
    {
        return $this->belongsToMany(User::class, 'church_planters', 'church_id', 'user_id');
    }
    */

    // Relationship to get all church planters in the community
    /*
    public function churchPlanters()
    {
        return $this->hasManyThrough(User::class, Church::class, 'community_id', 'id', 'id', 'id')
            ->join('church_planters', 'churches.id', '=', 'church_planters.church_id')
            ->whereColumn('users.id', 'church_planters.user_id')
            ->distinct(); // optional, in case same user appears more than once
    }
*/

    public function planters()
    {
        return User::whereHas('churches', function ($query) {
            $query->where('community_id', $this->id);
        })->get();
    }

    public function getChurchPlanters()
    {
        return ChurchPlanter::whereHas('church', function ($query) {
            $query->where('community_id', $this->id);
        })
            ->with(['user'])
            ->distinct()
            ->get()
            ->pluck('user')
            ->filter()
            ->unique('id')
            ->values();

        /*
        return User::whereHas('churches', function ($query) {
            $query->where('community_id', $this->id);
        })
            ->with('churches')
            ->get();
        */
    }

    public function churches()
    {
        return $this->hasMany(Church::class);
    }
}
