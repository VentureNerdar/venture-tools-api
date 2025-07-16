<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\ChurchMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $service)
    {
        $this->dashboardService = $service;
    }

    public function getInsightData()
    {
        $churchCount = $this->dashboardService->getChurchCount();
        $avgChurchSize = $this->dashboardService->getAvgChurchSize();
        $contactBaptizedCount = $this->dashboardService->getContactBaptizedCount();
        $baptizedMemberCount = $this->dashboardService->getBaptizedMemberCount();
        $provinces = $this->dashboardService->getProvinces();
        $districts = $this->dashboardService->getDistricts();
        $communities = $this->dashboardService->getCommunities();

        return response()->json([
            'church_count' => $churchCount,
            'avg_church_size' => $avgChurchSize,
            'contact_baptized_count' => $contactBaptizedCount,
            'baptized_member_count' => $baptizedMemberCount,
            'provinces' => $provinces,
            'districts' => $districts,
            'communities' => $communities,
        ]);
    }

    public function getLocationsOfChurch()
    {
        $user = Auth::user();
        $churchIDs = $this->dashboardService->getChurchIDsForUser($user);

        $query = Church::select('location_latitude', 'location_longitude', 'name')
            ->whereNotNull('location_latitude')
            ->whereNotNull('location_longitude');

        if ($churchIDs !== null) {
            $query->whereIn('id', $churchIDs);
        }

        $locations = $query->get()->map(function ($item) {
            return [
                'lat' => (float) $item->location_latitude,
                'lng' => (float) $item->location_longitude,
                'name' => $item->name,
            ];
        });

        return response()->json($locations);
    }

    public function getGenerationalChurchesByTree()
    {
        $rootUsers = User::whereNull('user_verifier_id')->get();
        $tree = $rootUsers->map(function ($user) {
            return $this->dashboardService->buildUserNode($user);
        });

        return response()->json($tree);
    }


    public function getGenerationalChurchesByGraph()
    {
        $users = User::select('id', 'name', 'user_verifier_id')->get();

        $nodes = $users->map(function ($user) {
            return [
                'id' => (string) $user->id,
                'name' => $user->name,
                'value' => 1
            ];
        });

        $links = $users->filter(fn($u) => $u->user_verifier_id !== null)
            ->map(function ($user) {
                return [
                    'source' => (string) $user->user_verifier_id,
                    'target' => (string) $user->id
                ];
            });

        return response()->json([
            'nodes' => $nodes->values(),
            'links' => $links->values()
        ]);
    }

    public function getPeopleGroups()
    {
        $user = Auth::user();
        $churchIDs = $this->dashboardService->getChurchIDsForUser($user);

        $query = ChurchMember::query();

        if ($churchIDs !== null) {
            $query->whereIn('church_id', $churchIDs);
        }

        $grouped = $query->get()->groupBy('people_group_id');

        $results = $grouped->map(function ($items, $groupId) {
            $churchIds = $items->pluck('church_id')->unique();
            $memberCount = $items->sum('amount');
            $churchCount = $churchIds->count();
            $baptismCount = Church::whereIn('id', $churchIds)->sum('baptism_count');
            $groupName = $items->first()->peopleGroup->name;

            return [
                'people_group_id' => $groupId,
                'name' => $groupName,
                'member_count' => $memberCount,
                'church_count' => $churchCount,
                'baptism_count' => $baptismCount,
            ];
        })->values();

        return $results;
    }
}
