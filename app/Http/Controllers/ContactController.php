<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\ListRequest;
use App\Models\Contact;
use App\Models\ContactCommunicationPlatform;
use App\Models\User;
use App\Services\CRUDService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ContactController
 *
 * @author John Doe <email@example.com>
 *
 * @see Controller
 */
class ContactController extends Controller
{
    protected $service;

    protected $model;

    protected $contactCommunicationPlatform;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = Contact::class;
        // $this->contactCommunicationPlatform = ContactCommunicationPlatform::class;
    }

    public function create(ContactRequest $request)
    {
        $data = $request->validated();

        if (isset($data['baptism_date']) && is_numeric($data['baptism_date'])) {
            // Dividing by 1000 to convert milliseconds to seconds
            $date = $data['baptism_date'];
            $data['baptism_date'] = Carbon::createFromTimestampMs($date / 1000);
        }

        $contact = $this->service->save($this->model, null, $data)[0];

        $contact->faithMilestones()->sync($data['faith_milestones'] ?? []);

        $contact->peopleGroup()->sync($data['people_group'] ?? []);

        $contactCommunicationPlatforms = $data['contact_communication_platforms'] ?? [];

        foreach ($contactCommunicationPlatforms as $platformData) {
            ContactCommunicationPlatform::create([
                'contact_id' => $contact->id,
                'communication_platform_id' => $platformData['communication_platform_id'],
                'value' => $platformData['value'],
            ]);
        }

        $contact->load(['faithMilestones', 'peopleGroup', 'contactCommunicationPlatforms']);

        // If is_active is false, soft delete the contact
        if (!$contact->is_active) {
            $contact->delete();
        }

        return response()->json($contact, 201);
    }

    public function update(ContactRequest $request, $id)
    {
        $data = $request->validated();

        if (isset($data['baptism_date']) && is_numeric($data['baptism_date'])) {
            // Dividing by 1000 to convert milliseconds to seconds
            $bDate = $data['baptism_date'];
            $data['baptism_date'] = Carbon::createFromTimestampMs($bDate / 1000);
        }

        $contact = $this->service->save($this->model, $id, $data)[0];

        $contact->faithMilestones()->sync($data['faith_milestones'] ?? []);
        $contact->peopleGroup()->sync($data['people_group'] ?? []);

        $contactCommunicationPlatforms = $data['contact_communication_platforms'] ?? [];
        $contact->contactCommunicationPlatforms()->delete();
        foreach ($contactCommunicationPlatforms as $platformData) {
            ContactCommunicationPlatform::create([
                'contact_id' => $contact->id,
                'communication_platform_id' => $platformData['communication_platform_id'],
                'value' => $platformData['value'],
            ]);
        }

        $contact->load(['faithMilestones', 'peopleGroup', 'contactCommunicationPlatforms']);

        // If is_active is false, soft delete the contact
        if (!$contact->is_active) {
            $contact->delete();
        }

        return response()->json($contact, 200);
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
        } else if ($user->user_role_id == 3) {
            $movementUsers = User::where('movement_id', $user->movement_id)->get()->pluck('id')->toArray();
            $request->merge([
                'where' => json_encode($existingWhere),
                'whereIn' => json_encode([
                    'key' => 'assigned_to',
                    'value' => $movementUsers
                ])
            ]);
        }
        return response()->json(...$this->service->browse($this->model, $request));
    }

    public function list(ListRequest $request)
    {
        $data = $request->validated();

        return response()->json(
            ...$this->service->list(
                $this->model,
                $data['labelOption'] ?? null,
                $data['limit'] ?? 10
            )
        );
    }

    public function delete($id, Request $request)
    {
        $contact = Contact::find($id);
        if ($contact) {
            $contact->update(['is_active' => false]);
        }
        return response()->json(
            ...$this->service->delete($this->model, $id, $request->force)
        );
    }

    public function trash($id)
    {
        return response()->json(...$this->service->delete($this->model, $id, false));
    }

    public function restore($id)
    {
        [$message, $status] = $this->service->restore($this->model, $id);
        if ($status === 200) {
            $contact = Contact::withTrashed()->find($id);
            if ($contact) {
                $contact->update(['is_active' => true]);
            }
        }
        return response()->json($message, $status);
    }
    public function view($id)
    {
        return $this->service->browse($this->model, null, $id);
    }
}
