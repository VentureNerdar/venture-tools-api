<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\ListRequest;
use App\Models\Contact;
use App\Models\ContactCommunicationPlatform;
use App\Services\CRUDService;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $data = $request->all();

        if (isset($data['baptism_date']) && is_numeric($data['baptism_date'])) {
            // Dividing by 1000 to convert milliseconds to seconds
            $date = $data['baptism_date'];
            $data['baptism_date'] = Carbon::createFromTimestampMs($date / 1000);
        }

        $contact = $this->service->save($this->model, null, $data)[0];

        $contact->faithMilestones()->sync($data['faith_milestones'] ?? []);
        $contact->peopleGroup()->sync($data['people_group'] ?? []);

        $contactCommunicationPlatforms = $request->input('contact_communication_platforms', []);

        foreach ($contactCommunicationPlatforms as $platformData) {
            ContactCommunicationPlatform::create([
                'contact_id' => $contact->id,
                'communication_platform_id' => $platformData['communication_platform_id'],
                'value' => $platformData['value'],
            ]);
        }

        $contact->load(['faithMilestones', 'peopleGroup', 'contactCommunicationPlatforms']);

        return response()->json($contact, 201);
    }

    public function update(ContactRequest $request, $id)
    {
        $data = $request->all();

        if (isset($data['baptism_date']) && is_numeric($data['baptism_date'])) {
            // Dividing by 1000 to convert milliseconds to seconds
            $bDate = $data['baptism_date'];
            $data['baptism_date'] = Carbon::createFromTimestampMs($bDate / 1000);
        }

        $contact = $this->service->save($this->model, $id, $data)[0];

        $contact->faithMilestones()->sync($data['faith_milestones'] ?? []);
        $contact->peopleGroup()->sync($data['people_group'] ?? []);

        // $contactCommunicationPlatforms = $request->only(['contact_communication_platforms']);
        $contactCommunicationPlatforms = $request->input('contact_communication_platforms', []);
        $contact->contactCommunicationPlatforms()->delete();
        foreach ($contactCommunicationPlatforms as $platformData) {
            ContactCommunicationPlatform::create([
                'contact_id' => $contact->id,
                'communication_platform_id' => $platformData['communication_platform_id'],
                'value' => $platformData['value'],
            ]);
        }

        $contact->load(['faithMilestones', 'peopleGroup', 'contactCommunicationPlatforms']);

        return response()->json($contact, 200);
    }

    public function browse(Request $request)
    {
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
        return $this->service->restore($this->model, $id);
    }
}
