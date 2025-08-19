<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Services\CRUDService;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\iShareAPISettingRequest;

class SettingController extends Controller
{
    protected $service;

    protected $settingService;

    protected $statusModel;

    public function __construct(CRUDService $service, SettingsService $settingService)
    {
        $this->service = $service;
        $this->statusModel = Status::class;
        $this->settingService = $settingService;
    }

    // Browse Statuses
    public function browseStatuses(Request $request)
    {
        return response()->json(...$this->service->browse($this->statusModel, $request));
    }
    // e.o Browse Statuses

    public function getPrayers(Request $request)
    {
        return response()->json($this->settingService->getChurchPlanterPrayers($request), 200);
    }

    public function getiShareAPISettings(Request $request)
    {
        if (Auth::user()->user_role_id === 1) {
            return response()->json($this->settingService->getiShareAPISettings($request), 200);
        } else {
            return response()->json(['message' => 'You are not authorized to access this resource'], 403);
        }
    }

    public function saveiShareAPISettings(iShareAPISettingRequest $request)
    {
        if (Auth::user()->user_role_id === 1) {
            return response()->json(
                $this->settingService->saveiShareAPISetting(
                    $request->validated('setting_name'),
                    $request->validated('setting_value')
                ),
                200
            );
        } else {
            return response()->json(['message' => 'You are not authorized to access this resource'], 403);
        }
    }
}
