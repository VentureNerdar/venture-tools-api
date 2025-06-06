<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PrayerPromptRequest;
use App\Http\Requests\ListRequest;
use App\Models\PrayerPrompt;
use App\Services\CRUDService;

class PrayerPromptController extends Controller
{
    protected $service;

    protected $model;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = PrayerPrompt::class;
    }

    public function create(PrayerPromptRequest $request)
    {
        return response()->json(...$this->service->save($this->model, null, $request->validated()));
    }

    public function update(PrayerPromptRequest $request, $id)
    {
        return response()->json(...$this->service->save($this->model, $id, $request->validated()));
    }

    public function browse(Request $request)
    {
        return response()->json(...$this->service->browse($this->model, $request));
    }

    public function list(ListRequest $request)
    {
        $data = $request->validated();

        return response()->json(...$this->service->list($this->model, $data['labelOption'] ?? null, $data['limit'] ?? 10));
    }

    public function delete($id, Request $request)
    {
        return response()->json(...$this->service->delete($this->model, $id, $request->force));
    }

    public function trash($id)
    {
        return response()->json(...$this->service->delete($this->model, $id, false));
    }

    public function restore($id)
    {
        return $this->service->restore($this->model, $id);
    }
}
