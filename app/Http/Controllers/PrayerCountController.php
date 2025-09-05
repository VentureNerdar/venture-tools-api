<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChurchPrayerCountRequest;
use App\Http\Requests\ContactPrayerCountRequest;
use App\Models\ChurchPrayerCount;
use App\Models\ContactPrayerCount;
use App\Services\CRUDService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrayerCountController extends Controller
{
    public function createChurchPrayerCount(ChurchPrayerCountRequest $request)
    {
        $validatedRequest = $request->validated();
        $authUser = Auth::user();
        ChurchPrayerCount::firstOrCreate([
            'church_id' => $validatedRequest['church_id'],
            'user_id' => $authUser->id,
        ]);

        return response()->json([
            'message' => 'Church prayer count is successfully created'
        ]);
    }

    public function createContactPrayerCount(ContactPrayerCountRequest $request)
    {
        $validatedRequest = $request->validated();
        $authUser = Auth::user();

        ContactPrayerCount::firstOrCreate([
            'contact_id' => $validatedRequest['contact_id'],
            'user_id' => $authUser->id
        ]);

        return response()->json([
            'message' => 'Contact prayer count is successfully created'
        ]);
    }
}
