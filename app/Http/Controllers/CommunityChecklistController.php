<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityChecklistRequest;
use App\Http\Requests\ListRequest;
use App\Models\CommunityChecklist;
use App\Services\CRUDService;
use Illuminate\Http\Request;

class CommunityChecklistController extends Controller
{
    protected $service;

    protected $model;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = CommunityChecklist::class;
    }

    public function create(CommunityChecklistRequest $request)
    {

        return response()->json(...$this->service->save($this->model, null, $request->validated()));
    }

    public function update(CommunityChecklistRequest $request, $id)
    {
        return response()->json(...$this->service->save($this->model, $id, $request->validated()));
    }

    public function browse(Request $request)
    {
        $request->merge([
            'sort' => json_encode([
                'key' => 'order',
                'order' => 'desc'
            ])
        ]);
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

    public function updateAll(Request $request)
    {
        $data = $request->all();
        $validated = $request->validate([
            '*.id' => 'required|integer|exists:community_checklists,id',
            '*.name' => 'required|string',
            '*.order' => 'required|integer',
        ]);
        foreach ($validated as $item) {
            CommunityChecklist::where('id', $item['id'])->update([
                'name' => $item['name'],
                'order' => $item['order'],
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'message' => 'Checklist items updated successfully.',
            'count' => count($data),
        ]);
    }
}
