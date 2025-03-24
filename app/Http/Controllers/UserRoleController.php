<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CRUDService;
use App\Models\UserRole;
use App\Http\Requests\UserRoleRequest;

class UserRoleController extends Controller
{
    protected $service;
    protected $model;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = UserRole::class;
    }

    public function create(UserRoleRequest $request)
    {
        return response()->json(...$this->service->save($this->model, null, $request->all()));
    }

    public function update(UserRoleRequest $request, $id)
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

    public function restore($id)
    {
        return $this->service->restore($this->model, $id);
    }
}
