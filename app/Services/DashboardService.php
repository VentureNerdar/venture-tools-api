<?php

namespace App\Services;

use App\Models\Church;
use App\Models\ChurchMember;
use App\Models\Community;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Contact;
use App\Models\District;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getChurchIDsForUser(User $user)
    {
        $roleId = $user->user_role_id;

        if ($roleId === 3) {
            // Movement Leader
            $discipleMakerIDs = User::where('movement_id', $user->movement_id)
                ->where('user_role_id', 4)
                ->pluck('id');

            return Church::whereIn('assigned_to', $discipleMakerIDs)->pluck('id');
        }

        if ($roleId === 4) {
            // Disciple Maker
            return Church::where('assigned_to', $user->id)->pluck('id');
        }

        return null;
    }

    public function getLocationsIDs(User $user, $locationType)
    {
        $roleID = $user->user_role_id;
        if ($roleID === 3) {
            $discipleMakerIDs = User::where('movement_id', $user->movement_id)
                ->where('user_role_id', 4)
                ->pluck('id');
            return Church::whereIn('assigned_to', $discipleMakerIDs)->pluck($locationType)->unique();
        } else if ($roleID === 4) {
            return Church::where('assigned_to', $user->id)->pluck($locationType)->unique();
        }
    }
    public function buildUserNode(User $user)
    {
        $children = User::where('user_verifier_id', $user->id)->get();

        return [
            'name' => $user->name,
            'id' => $user->id,
            'children' => $children->map(function ($child) {
                return $this->buildUserNode($child);
            })->toArray()
        ];
    }

    public function getChurchCount()
    {
        $user = Auth::user();
        $churchIDs = $this->getChurchIDsForUser($user);

        $query = Church::selectRaw('COUNT(*) as amount');

        if ($churchIDs !== null) {
            $query->whereIn('id', $churchIDs);
        }

        $amount = $query->value('amount');
        return $amount;
    }

    public function getAvgChurchSize()
    {
        $user = Auth::user();
        $churchIDs = $this->getChurchIDsForUser($user);

        $subQuery = DB::table('church_members')
            ->select('church_id', DB::raw('SUM(amount) as total'))
            ->groupBy('church_id');

        if ($churchIDs !== null) {
            $subQuery->whereIn('church_id', $churchIDs);
        }

        $query = DB::table('churches as c')
            ->leftJoinSub($subQuery, 'pg', 'c.id', '=', 'pg.church_id')
            ->select(DB::raw('AVG(COALESCE(pg.total, c.church_members_count)) as avg_church_size'));

        if ($churchIDs !== null) {
            $query->whereIn('c.id', $churchIDs);
        }

        $avg = (int) $query->value('avg_church_size');

        return $avg;
    }

    public function getContactBaptizedCount()
    {
        $user = Auth::user();
        $contactBaptizedCount = 0;
        if ($user->user_role_id == 4) {
            $contactBaptizedCount = Contact::where(function ($query) {
                $query->whereNotNull('baptized_by')
                    ->orWhereNotNull('baptized_by_name');
            })
                ->where('assigned_to', $user->id)
                ->count();
        } elseif ($user->user_role_id == 3) {
            $discipleMakerIDs = User::where('movement_id', $user->movement_id)
                ->where('user_role_id', 4)
                ->pluck('id');
            $contactBaptizedCount = Contact::where(function ($query) {
                $query->whereNotNull('baptized_by')
                    ->orWhereNotNull('baptized_by_name');
            })
                ->whereIn('assigned_to', $discipleMakerIDs)
                ->count();
        } else {
            $contactBaptizedCount = Contact::whereNotNull('baptized_by')
                ->orWhereNotNull('baptized_by_name')
                ->count();
        }
        return $contactBaptizedCount;
    }

    public function getBaptizedMemberCount()
    {
        $user = Auth::user();
        $churchIDs = $this->getChurchIDsForUser($user);

        $query = Church::selectRaw('SUM(baptism_count) as amount');

        if ($churchIDs !== null) {
            $query->whereIn('id', $churchIDs);
        }

        $amount = $query->value('amount');

        return $amount;
    }

    public function getProvinces()
    {
        $user = Auth::user();
        $locationIDs = $this->getLocationsIDs($user, 'province_id');

        if ($locationIDs === null) {
            return Province::count();
        }
        $provinces = Province::whereIn('id', $locationIDs)->count();
        return $provinces;
    }

    public function getDistricts()
    {
        $user = Auth::user();
        $locationIDs = $this->getLocationsIDs($user, 'district_id');

        if ($locationIDs === null) {
            return District::count();
        }
        $districts = District::whereIn('id', $locationIDs)->count();
        return $districts;
    }

    public function getCommunities()
    {
        $user = Auth::user();
        if ($user->user_role_id == 3) {
            $discipleMakerIDs = User::where('movement_id', $user->movement_id)
                ->where('user_role_id', 4)
                ->pluck('id');
            return Community::whereIn('created_by', $discipleMakerIDs)->count();
        } else if ($user->user_role_id == 4) {
            return Community::where('created_by', $user->id)->count();
        }
        $communities = Community::count();
        return $communities;
    }
}
