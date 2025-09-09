<?php

namespace App\Services;

use App\Models\User;
use App\Models\Church;
use App\Models\ChurchPlanter;
use App\Models\ChurchPrayerCount;
use App\Models\Contact;
use App\Models\ContactPrayerCount;
use App\Models\Setting;
use Illuminate\Http\Request;
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
    public function getChurchPlanterPrayers(Request $request)
    {
        // Always initialize as arrays
        $churchPlanterPrayers = [];
        $assignedToChurchPrayers = [];
        $assignedToContactPrayers = [];
        $allChurchPrayers = [];
        $allContactPrayers = [];
        $authUser = Auth::user();
        $perPage = $request->with;

        if ($authUser->user_role_id === 3) { // if movement leader
            $movementUsers = User::where('movement_id', $authUser->movement_id)->get()->pluck('id')->toArray();
            $churchIds = ChurchPlanter::whereHas('user', function ($query) use ($authUser) {
                $query->where('id', $authUser->id);
            })
                ->pluck('church_id')
                ->unique()
                ->toArray();
            Log::info("churchIDs", ['churchIds' => $churchIds]);

            $churchPlanterPrayers = Church::whereIn('id', $churchIds)
                ->orderBy('id', 'desc')
                ->paginate($perPage);
            $churchPlanterPrayers->getCollection()->transform(function ($church) use ($authUser) {
                $church->prayer_count = ChurchPrayerCount::where('church_id', $church->id)->count();
                $church->user_has_prayed = ChurchPrayerCount::where('church_id', $church->id)
                    ->where('user_id', $authUser->id)
                    ->exists();
                return $church;
            });

            $assignedToChurchPrayers = Church::whereIn('assigned_to', $movementUsers)
                ->whereNotNull('current_prayers')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            $assignedToChurchPrayers->getCollection()->transform(function ($church) use ($authUser) {
                $church->prayer_count = ChurchPrayerCount::where('church_id', $church->id)->count();
                $church->user_has_prayed = ChurchPrayerCount::where('church_id', $church->id)
                    ->where('user_id', $authUser->id)
                    ->exists();
                return $church;
            });
            // ->map(function ($church) use ($authUser) {
            //     $church->prayer_count = ChurchPrayerCount::where('church_id', $church->id)->count();
            //     $church->user_has_prayed = ChurchPrayerCount::where('church_id', $church->id)
            //         ->where('user_id', $authUser->id)
            //         ->exists();
            //     return $church;
            // });


            $assignedToContactPrayers = Contact::where('assigned_to', $movementUsers)
                ->whereNotNull('current_prayers')
                ->orderBy('id', 'desc')
                ->paginate($perPage);
            $assignedToContactPrayers->getCollection()->transform(function ($contact) use ($authUser) {
                $contact->prayer_count = ContactPrayerCount::where('contact_id', $contact->id)->count();
                $contact->user_has_prayed = ContactPrayerCount::where('contact_id', $contact->id)
                    ->where('user_id', $authUser->id)
                    ->exists();
                return $contact;
            });
        } elseif ($authUser->user_role_id === 4) { // if disciple maker

            $churchIds = ChurchPlanter::whereHas('user', function ($query) use ($authUser) {
                $query->where('id', $authUser->id);
            })
                ->pluck('church_id')
                ->unique()
                ->toArray();

            $churchPlanterPrayers = Church::whereIn('id', $churchIds)
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            $churchPlanterPrayers->getCollection()->transform(function ($church) use ($authUser) {
                $church->prayer_count = ChurchPrayerCount::where('church_id', $church->id)->count();
                $church->user_has_prayed = ChurchPrayerCount::where('church_id', $church->id)
                    ->where('user_id', $authUser->id)
                    ->exists();
                return $church;
            });


            $assignedToChurchPrayers = Church::where('assigned_to', $authUser->id)
                ->whereNotNull('current_prayers')
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            $assignedToChurchPrayers->getCollection()->transform(function ($church) use ($authUser) {
                $church->prayer_count = ChurchPrayerCount::where('church_id', $church->id)->count();
                $church->user_has_prayed = ChurchPrayerCount::where('church_id', $church->id)
                    ->where('user_id', $authUser->id)
                    ->exists();
                return $church;
            });

            $assignedToContactPrayers = Contact::where('assigned_to', $authUser->id)
                ->whereNotNull('current_prayers')
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            $assignedToContactPrayers->getCollection()->transform(function ($contact) use ($authUser) {
                $contact->prayer_count = ContactPrayerCount::where('contact_id', $contact->id)->count();
                $contact->user_has_prayed = ContactPrayerCount::where('contact_id', $contact->id)
                    ->where('user_id', $authUser->id)
                    ->exists();
                return $contact;
            });
        } elseif ($authUser->user_role_id === 1) {
            $allChurchPrayers = Church::whereNotNull('current_prayers')
                ->where('current_prayers', '!=', '')
                ->orderBy('id', 'desc')
                ->paginate($perPage);

            $allChurchPrayers->getCollection()->transform(function ($church) use ($authUser) {
                $church->prayer_count = ChurchPrayerCount::where('church_id', $church->id)->count();
                $church->user_has_prayed = ChurchPrayerCount::where('church_id', $church->id)
                    ->where('user_id', $authUser->id)
                    ->exists();
                return $church;
            });

            $allContactPrayers = Contact::whereNotNull('current_prayers')
                ->where('current_prayers', '!=', '')
                ->orderBy('id', 'desc')
                ->paginate($perPage);
            $allContactPrayers->getCollection()->transform(function ($contact) use ($authUser) {
                $contact->prayer_count = ContactPrayerCount::where('contact_id', $contact->id)->count();
                $contact->user_has_prayed = ContactPrayerCount::where('contact_id', $contact->id)
                    ->where('user_id', $authUser->id)
                    ->exists();
                return $contact;
            });
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
