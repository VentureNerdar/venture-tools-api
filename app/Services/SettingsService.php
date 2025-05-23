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

            $assignedToChurchPrayers = Church::whereIn('assigned_to', $movementUsers)->get();
            $assignedToContactPrayers = Contact::where('assigned_to', $movementUsers)->get();
        } else if ($authUser->user_role_id === 4) { // if disciple maker

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

            $assignedToChurchPrayers = Church::where('assigned_to', $authUser->id)->get();
            $assignedToContactPrayers = Contact::where('assigned_to', $authUser->id)->get();
        }

        return [
            'churchPrayers' => [...$churchPlanterPrayers, ...$assignedToChurchPrayers],
            'contactPrayers' => $assignedToContactPrayers,
        ];
    }
}
