<?php

namespace App\Services;

use App\Models\User;
use App\Models\Church;
use App\Models\ChurchPlanter;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class SettingsService
{
    public function getChurchPlanterPrayers()
    {
        // Always initialize as arrays
        $churchPlanterPrayers = [];
        $assignedToChurchPrayers = [];
        $assignedToContactPrayers = [];
        $allChurchPrayers = [];
        $allContactPrayers = [];
        $authUser = Auth::user();

        if ($authUser->user_role_id === 3) { // if movement leader
            $movementUsers = User::where('movement_id', $authUser->movement_id)->get()->pluck('id')->toArray();

            $churchPlanterPrayers = ChurchPlanter::whereHas('user', function ($query) use ($movementUsers) {
                $query->whereIn('id', $movementUsers);
            })
                ->with(['church'])
                ->distinct()
                ->get()
                ->pluck('church')
                ->filter()
                ->unique('id')
                ->values();

            $assignedToChurchPrayers = Church::whereIn('assigned_to', $movementUsers)
                ->whereNotNull('current_prayers')
                ->orderBy('created_at', 'desc')
                ->get();
            $assignedToContactPrayers = Contact::where('assigned_to', $movementUsers)
                ->whereNotNull('current_prayers')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($authUser->user_role_id === 4) { // if disciple maker

            $churchPlanterPrayers = ChurchPlanter::whereHas('user', function ($query) use ($authUser) {
                $query->where('id', $authUser->id);
            })
                ->with(['church'])
                ->distinct()
                ->get()
                ->pluck('church')
                ->filter()
                ->unique('id')
                ->values();

            $assignedToChurchPrayers = Church::where('assigned_to', $authUser->id)
                ->whereNotNull('current_prayers')
                ->orderBy('created_at', 'desc')
                ->get();
            $assignedToContactPrayers = Contact::where('assigned_to', $authUser->id)
                ->whereNotNull('current_prayers')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($authUser->user_role_id === 1) {
            $allChurchPrayers = Church::whereNotNull('current_prayers')
                ->where('current_prayers', '!=', '')
                ->orderBy('created_at', 'desc')
                ->get();

            $allContactPrayers = Contact::whereNotNull('current_prayers')
                ->where('current_prayers', '!=', '')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return [
            'churchPrayers' => [
                ...($churchPlanterPrayers ?? []),
                ...($assignedToChurchPrayers ?? []),
                ...($allChurchPrayers ?? [])
            ],
            'contactPrayers' => [
                ...($assignedToContactPrayers ?? []),
                ...($allContactPrayers ?? [])
            ],
        ];
    }
}
