<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityRequest;
use App\Http\Requests\ListRequest;
use App\Models\Community;
use App\Services\CRUDService;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    protected $service;

    protected $model;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = Community::class;
    }

    public function create(CommunityRequest $request)
    {
        $community = $this->service->save($this->model, null, $request->all())[0];

        // checklists
        $checklists = $request->input('checklists', []);
        $community->checklists()->sync($checklists);

        // Sync Peace Persons
        $peacePersons = $request->input('peace_persons', []);
        if (! empty($peacePersons)) {
            $community->peacePersons()->createMany($peacePersons);
        }

        // Sync Committees (HasMany)
        $committees = $request->input('committees', []);
        if (! empty($committees)) {
            $community->committees()->createMany($committees);
        }

        $community->load(['checklists']);

        return response()->json($community, 201);
    }

    public function update(CommunityRequest $request, $id)
    {
        $community = $this->service->save($this->model, $id, $request->all())[0];

        // checklists
        $checklists = $request->input('checklists', []);
        $community->checklists()->sync($checklists);

        // peace persons
        $peacePersons = $request->input('peace_persons', []);

        $existingIds = $community->peacePersons()->pluck('id')->toArray();
        $incomingIds = collect($peacePersons)->pluck('id')->filter()->toArray();

        // Update existing
        foreach ($peacePersons as $person) {
            if (! empty($person['id']) && in_array($person['id'], $existingIds)) {
                $community->peacePersons()->where('id', $person['id'])->update([
                    'name' => $person['name'] ?? null,
                    'email' => $person['email'] ?? null,
                    'phone' => $person['phone'] ?? null,
                ]);
            }
        }

        // Create new
        $newPersons = collect($peacePersons)->filter(fn ($p) => empty($p['id']))->values()->all();
        if (! empty($newPersons)) {
            $community->peacePersons()->createMany($newPersons);
        }

        // Delete removed
        $toDelete = array_diff($existingIds, $incomingIds);
        if (! empty($toDelete)) {
            $community->peacePersons()->whereIn('id', $toDelete)->delete();
        }

        // committees
        $committees = $request->input('committees', []);

        $existingIds = $community->committees()->pluck('id')->toArray();
        $incomingIds = collect($committees)->pluck('id')->filter()->toArray();

        // Update existing
        foreach ($committees as $committee) {
            if (! empty($committee['id']) && in_array($committee['id'], $existingIds)) {
                $community->committees()->where('id', $committee['id'])->update([
                    'name' => $committee['name'] ?? null,
                ]);
            }
        }

        // Create new
        $newCommittees = collect($committees)->filter(fn ($c) => empty($c['id']))->values()->all();
        if (! empty($newCommittees)) {
            $community->committees()->createMany($newCommittees);
        }

        // Delete removed
        $toDelete = array_diff($existingIds, $incomingIds);
        if (! empty($toDelete)) {
            $community->committees()->whereIn('id', $toDelete)->delete();
        }

        $community->load(['checklists', 'committees', 'peacePersons']);

        return response()->json($community, 200);
    }

    public function browse(Request $request)
    {
        [$communities, $status] = $this->service->browse($this->model, $request);

        foreach ($communities as $community) {
            $community->churchPlanters = $community->getChurchPlanters();
        }

        return response()->json($communities, $status);
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
}
