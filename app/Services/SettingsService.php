<?php

namespace App\Services;

use App\Models\User;
use App\Models\Church;
use App\Models\ChurchPlanter;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

enum iShareAPISettingName: string
{
    case UserName = 'iShareAPIUserName';
    case Secret = 'iShareAPISecret';
    case URL = 'iShareAPIURL';
}

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

    public function getiShareAPISettings()
    {
        return Setting::where('name', 'like', 'iShareAPI%')->get();
    }

    public function saveiShareAPISetting($settingName, $value)
    {
        try {
            Setting::updateOrCreate(
                ['name' => $settingName],
                ['value' => json_encode($value)]
            );

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
