<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemLanguageRequest;
use App\Models\SystemLanguage;
use Illuminate\Http\Request;
use App\Services\CRUDService;

class SystemLanguageController extends Controller
{
    //
    protected $service;
    protected $model;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = SystemLanguage::class;
    }

    public function create(SystemLanguageRequest $request)
    {
        return response()->json(...$this->service->save($this->model, null, $request->all()));
    }

    public function update(SystemLanguageRequest $request, $id)
    {
        return response()->json(...$this->service->save($this->model, $id, $request->all()));
    }

    public function browse(Request $request)
    {
        return response()->json(...$this->service->browse($this->model, $request));
    }

    public function view($id)
    {
        // return $this->service->browse($this->model, null, $id);
    }

    public function trash($id)
    {
        // return $this->service->delete($this->model, $id, true);
    }

    public function delete($id)
    {
        return response()->json(...$this->service->delete($this->model, $id));
    }
}
