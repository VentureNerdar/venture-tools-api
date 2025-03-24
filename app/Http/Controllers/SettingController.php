<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Services\CRUDService;
use App\Services\SettingsService;
use Illuminate\Http\Request;

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
}
