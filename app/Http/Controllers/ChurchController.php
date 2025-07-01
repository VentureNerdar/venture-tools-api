<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChurchRequest;
use App\Http\Requests\ListRequest;
use App\Models\Church;
use App\Models\ChurchMember;
use App\Models\ChurchPlanter;
use App\Models\User;
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
        $request->merge([
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
        $church = $this->service->save($this->model, null, $request->all())[0];

        $churchPlanters = $request->input('church_planters', []);

        foreach ($churchPlanters as $planterData) {
            ChurchPlanter::create([
                'church_id' => $church->id,
                'user_id' => $planterData,
            ]);
        }
        if ($church->member_count_by_people_group) {
            $churchMembers = $request->input('member_count_list_by_people_group', []);
            foreach ($churchMembers as $memberData) {
                ChurchMember::create([
                    'church_id' => $church->id,
                    'people_group_id' => $memberData['people_group_id'],
                    'amount' => $memberData['amount'],
                ]);
            }
        }

        // If is_active is false, soft delete the church
        if (!$church->is_active) {
            $church->delete();
        }

        return response()->json($church, 201);
    }

    public function update(ChurchRequest $request, $id)
    {
        $request->merge([
            'updated_by' => Auth::user()->id,
        ]);
        $church = $this->service->save($this->model, $id, $request->all())[0];
        $churchPlanters = $request->input('church_planters', []);
        $church->churchPlanters()->delete();
        foreach ($churchPlanters as $planterData) {
            ChurchPlanter::create([
                'church_id' => $church->id,
                'user_id' => $planterData,
            ]);
        }
        if ($church->member_count_by_people_group) {
            $churchMembers = $request->input('member_count_list_by_people_group', []);

            $church->churchMembers()->delete();
            foreach ($churchMembers as $memberData) {
                ChurchMember::create([
                    'church_id' => $church->id,
                    'people_group_id' => $memberData['people_group_id'],
                    'amount' => $memberData['amount'],
                ]);
            }
        } else {
            $church->churchMembers()->delete();
        }

        $church->load(['churchPlanters']);
        if (!$church->is_active) {
            $church->delete();
        }

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
        } elseif ($user->user_role_id == 3) {
            $movementUsers = User::where('movement_id', $user->movement_id)->get()->pluck('id')->toArray();
            $request->merge([
                'where' => json_encode($existingWhere),
                'whereIn' => json_encode([
                    'key' => 'assigned_to',
                    'value' => $movementUsers
                ])
            ]);
        }
        $churches = $this->service->browse($this->model, $request);
        return response()->json(...$churches);
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
        $church = Church::find($id);
        if ($church) {

            $church->update(['is_active' => false]);
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
            $church = Church::withTrashed()->find($id);
            if ($church) {
                $church->update(['is_active' => true]);
            }
        }
        return response()->json($message, $status);
    }

    public function view($id)
    {
        return $this->service->browse($this->model, null, $id);
    }

    public function createChurchPlanters(Request $request)
    {
        $request->validate([
            'church_id' => 'required|exists:churches,id',
            'church_planters' => 'required|array',
            'church_planters.*' => 'required|exists:users,id'
        ]);

        $churchPlanters = [];
        foreach ($request->church_planters as $userId) {
            $churchPlanters[] = ChurchPlanter::create([
                'church_id' => $request->church_id,
                'user_id' => $userId
            ]);
        }

        return response()->json($churchPlanters, 201);
    }
}
