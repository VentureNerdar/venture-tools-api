<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommunityRequest;
use App\Http\Requests\ListRequest;
use App\Models\Community;
use App\Models\District;
use App\Models\Province;
use App\Models\User;
use App\Services\CRUDService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $data = $request->validated();
        if (!empty($data['province_name'])) {
            $province = Province::firstOrCreate([
                'name' => $data['province_name']
            ]);
            $data['province_id'] = $province->id;
        }
        if (!empty($data['district_name'])) {
            $district = District::firstOrCreate([
                'name' => $data['district_name']
            ]);
            $data['district_id'] = $district->id;
        }
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;
        $community = $this->service->save($this->model, null, $data)[0];

        // checklists
        $checklists = $data['checklists'] ?? [];
        $community->checklists()->sync($checklists);

        // Sync Peace Persons
        // $peacePersons = $request->input('peace_persons', []);
        $peacePersons = $data['peace_persons'] ?? [];
        if (! empty($peacePersons)) {
            $community->peacePersons()->createMany($peacePersons);
        }

        // Sync Committees (HasMany)
        $committees = $data['committees'] ?? [];
        // $committees = $request->input('committees', []);
        if (! empty($committees)) {
            $community->committees()->createMany($committees);
        }

        $community->load(['checklists']);

        // If is_active is false, soft delete the community
        if (!$community->is_active) {
            $community->delete();
        }

        return response()->json($community, 201);
    }

    public function update(CommunityRequest $request, $id)
    {
        $data = $request->validated();
        if (!empty($data['province_name'])) {
            $province = Province::firstOrCreate([
                'name' => $data['province_name']
            ]);
            $data['province_id'] = $province->id;
        }
        if (!empty($data['district_name'])) {
            $district = District::firstOrCreate([
                'name' => $data['district_name']
            ]);
            $data['district_id'] = $district->id;
        }
        $data['updated_by'] = Auth::user()->id;
        $community = $this->service->save($this->model, $id, $data)[0];

        // checklists
        // $checklists = $data['checklists'] ?? [];
        $checklists = $request->input('checklists', []);
        $community->checklists()->sync($checklists);

        // peace persons
        // $peacePersons = $data['peace_persons'] ?? [];
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
        $newPersons = collect($peacePersons)->filter(fn($p) => empty($p['id']))->values()->all();
        if (! empty($newPersons)) {
            $community->peacePersons()->createMany($newPersons);
        }

        // Delete removed
        $toDelete = array_diff($existingIds, $incomingIds);
        if (! empty($toDelete)) {
            $community->peacePersons()->whereIn('id', $toDelete)->delete();
        }

        // committees
        $committees = $data['committees'] ?? [];
        // $committees = $request->input('committees', []);

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
        $newCommittees = collect($committees)->filter(fn($c) => empty($c['id']))->values()->all();
        if (! empty($newCommittees)) {
            $community->committees()->createMany($newCommittees);
        }

        // Delete removed
        $toDelete = array_diff($existingIds, $incomingIds);
        if (! empty($toDelete)) {
            $community->committees()->whereIn('id', $toDelete)->delete();
        }

        $community->load(['checklists', 'committees', 'peacePersons']);

        // If is_active is false, soft delete the community
        if (!$community->is_active) {
            $community->delete();
        }

        return response()->json($community, 200);
    }

    public function browse(Request $request)
    {
        $user = Auth::user();
        $existingWhere = $request->has('where') ? json_decode($request->where, true) : [];
        if ($user->user_role_id == 4) {
            $existingWhere[] = [
                'key' => 'created_by',
                'value' => $user->id,
            ];

            $request->merge([
                'where' => json_encode($existingWhere),
            ]);
        } else if ($user->user_role_id == 3) {
            $movementUsers = User::where('movement_id', $user->movement_id)->get()->pluck('id')->toArray();
            $request->merge([
                'where' => json_encode($existingWhere),
                'whereIn' => json_encode([
                    'key' => 'created_by',
                    'value' => $movementUsers
                ])
            ]);
        }

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
        $community = Community::find($id);
        if ($community) {
            $community->update(['is_active' => false]);
        }
        return response()->json(...$this->service->delete($this->model, $id, $request->force));
    }

    public function trash($id)
    {
        return response()->json(...$this->service->delete($this->model, $id, false));
    }

    public function restore($id)
    {
        [$message, $status] = $this->service->restore($this->model, $id);
        if ($status === 200) {
            $community = Community::withTrashed()->find($id);
            if ($community) {
                $community->update(['is_active' => true]);
            }
        }
        return response()->json($message, $status);
    }
}
