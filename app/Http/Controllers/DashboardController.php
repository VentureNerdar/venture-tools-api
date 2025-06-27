<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\ChurchMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class DashboardController extends Controller
{

    public function getChurchMemberCount()
    {
        $user = Auth::user();
        $userRoleID = $user->user_role_id;

        $churchIDs = null;

        if ($userRoleID === 3) {
            // Movement Leader
            $discipleMakerIDs = User::where('movement_id', $user->movement_id)
                ->where('user_role_id', 4)
                ->pluck('id');

            $churchIDs = Church::whereIn('assigned_to', $discipleMakerIDs)->pluck('id');
        }

        if ($userRoleID === 4) {
            // Disciple Maker
            $churchIDs = Church::where('assigned_to', $user->id)->pluck('id');
        }

        $query = Church::selectRaw('SUM(church_members_count) as amount');

        if ($churchIDs !== null) {
            $query->whereIn('id', $churchIDs);
        }

        $amountsByPeopleGroup = $query->get();

        $result = $amountsByPeopleGroup->map(function ($item) {
            return [
                'total_amount' => (int) $item->amount,
            ];
        });

        return response()->json($result);
    }

    public function getChurchMemberCountByPeopleGroup()
    {
        $user = Auth::user();
        $userRoleID = $user->user_role_id;

        $churchIDs = null;

        if ($userRoleID === 3) {
            // Movement Leader
            $discipleMakerIDs = User::where('movement_id', $user->movement_id)
                ->where('user_role_id', 4)
                ->pluck('id');

            $churchIDs = Church::whereIn('assigned_to', $discipleMakerIDs)->pluck('id');
        }

        if ($userRoleID === 4) {
            // Disciple Maker
            $churchIDs = Church::where('assigned_to', $user->id)->pluck('id');
        }

        $query = ChurchMember::with('peopleGroup')
            ->select('people_group_id')
            ->selectRaw('SUM(amount) as amount')
            ->groupBy('people_group_id');

        if ($churchIDs !== null) {
            $query->whereIn('church_id', $churchIDs);
        }

        $amountsByPeopleGroup = $query->get();

        $result = $amountsByPeopleGroup->map(function ($item) {
            return [
                'people_group_id' => $item->people_group_id,
                'people_group_name' => $item->peopleGroup?->name,
                'total_amount' => (int) $item->amount,
            ];
        });

        return response()->json($result);
    }
}
