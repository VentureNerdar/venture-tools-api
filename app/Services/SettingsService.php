<?php

namespace App\Services;

use App\Models\Church;
use App\Models\ChurchPlanter;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class SettingsService
{
    public function getChurchPlanterPrayers()
    {
        $authID = Auth::user()->id;

        $churchPlanterPrayers = ChurchPlanter::whereHas('user', function ($query) use ($authID) {
            $query->where('id', $authID);
        })
            ->with(['church'])
            ->distinct()
            ->get()
            ->pluck('church')
            ->filter()
            ->unique('id')
            ->values();

        $assignedToChurchPrayers = Church::where('assigned_to', $authID)->get();
        $assignedToContactPrayers = Contact::where('assigned_to', $authID)->get();

        return [
            'churchPlanterPrayers' => $churchPlanterPrayers,
            'assignedToChurchPrayers' => $assignedToChurchPrayers,
            'assignedToContactPrayers' => $assignedToContactPrayers,
        ];
    }
}
