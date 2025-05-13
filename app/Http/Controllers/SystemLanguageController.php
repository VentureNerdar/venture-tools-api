<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemLanguageRequest;
use App\Http\Requests\SystemLanguageTranslationRequest;
use App\Models\SystemLanguage;
use App\Models\SystemLanguageTranslation;
use App\Services\CRUDService;
use Illuminate\Http\Request;

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
        return response()->json(...$this->service->save($this->model, null, $request->validated()));
    }

    public function update(SystemLanguageRequest $request, $id)
    {
        return response()->json(...$this->service->save($this->model, $id, $request->validated()));
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

    public function createTranslation(SystemLanguageTranslationRequest $request)
    {
        $translation = SystemLanguageTranslation::create($request->validated());

        return response()->json($translation, 201);
    }

    public function updateTranslation(SystemLanguageTranslationRequest $request, $id)
    {
        $translation = SystemLanguageTranslation::findOrFail($id);

        $translation->update($request->validated());

        return response()->json($translation, 200);
    }
}
