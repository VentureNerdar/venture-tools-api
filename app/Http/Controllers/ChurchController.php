<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChurchRequest;
use App\Http\Requests\ListRequest;
use App\Models\Church;
use App\Models\ChurchPlanter;
use App\Services\CRUDService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChurchController extends Controller
{
    protected $service;

    protected $model;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = Church::class;
    }

    public function create(ChurchRequest $request)
    {
        $church = $this->service->save($this->model, null, $request->all())[0];

        $churchPlanters = $request->input('church_planters', []);

        foreach ($churchPlanters as $planterData) {
            ChurchPlanter::create([
                'church_id' => $church->id,
                'user_id' => $planterData,
            ]);
        }

        return response()->json($church, 201);
    }

    public function update(ChurchRequest $request, $id)
    {
        $church = $this->service->save($this->model, $id, $request->all())[0];
        $churchPlanters = $request->input('church_planters', []);
        $church->churchPlanters()->delete();
        foreach ($churchPlanters as $planterData) {
            ChurchPlanter::create([
                'church_id' => $church->id,
                'user_id' => $planterData,
            ]);
        }

        $church->load(['churchPlanters']);

        return response()->json($church, 200);
    }

    public function browse(Request $request)
    {
        $user = Auth::user();
        $existingWhere = $request->has('where') ? json_decode($request->where, true) : [];
        if ($user->user_role_id == 4) {
            $existingWhere[] = [
                'key' => 'assigned_to',
                'value' => $user->id,
            ];

            $request->merge([
                'where' => json_encode($existingWhere)
            ]);
        }
        return response()->json(...$this->service->browse($this->model, $request));
    }

    public function list(ListRequest $request)
    {
        $data = $request->validated();

        return response()->json(
            ...$this->service->list($this->model, $data['labelOption'] ?? null, $data['limit'] ?? 10)
        );
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

    public function view($id)
    {
        return $this->service->browse($this->model, null, $id);
    }
}
