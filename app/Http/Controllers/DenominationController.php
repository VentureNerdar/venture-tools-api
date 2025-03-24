<?php

namespace App\Http\Controllers;

use App\Http\Requests\DenominationRequest;
use App\Http\Requests\ListRequest;
use App\Models\Denomination;
use App\Services\CRUDService;
use Illuminate\Http\Request;

class DenominationController extends Controller
{
    protected $service;

    protected $model;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = Denomination::class;
    }

    public function create(DenominationRequest $request)
    {
        return response()->json(...$this->service->save($this->model, null, $request->all()));
    }

    public function update(DenominationRequest $request, $id)
    {
        return response()->json(...$this->service->save($this->model, $id, $request->all()));
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
