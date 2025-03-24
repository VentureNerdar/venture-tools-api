<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CRUDService;
use App\Http\Requests\PeopleGroupRequest;
use App\Models\PeopleGroup;

class PeopleGroupController extends Controller
{

    protected $service;
    protected $model;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = PeopleGroup::class;
    }

    public function create(PeopleGroupRequest $request)
    {
        return response()->json(...$this->service->save($this->model, null, $request->all()));
    }

    public function update(PeopleGroupRequest $request, $id)
    {
        return response()->json(...$this->service->save($this->model, $id, $request->all()));
    }

    public function browse(Request $request)
    {
        return response()->json(...$this->service->browse($this->model, $request));
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
