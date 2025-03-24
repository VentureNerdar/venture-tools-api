<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CRUDService;
use App\Http\Requests\FaithMilestoneRequest;
use App\Models\FaithMilestone;

class FaithMilestoneController extends Controller
{
    protected $service;
    protected $model;


    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = FaithMilestone::class;
    }

    public function create(FaithMilestoneRequest $request)
    {
        return response()->json(...$this->service->save($this->model, null, $request->all()));
    }

    public function update(FaithMilestoneRequest $request, $id)
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

    public function trash($id)
    {
        return response()->json(...$this->service->delete($this->model, $id, false));
    }

    public function restore($id)
    {
        return $this->service->restore($this->model, $id);
    }

    public function uploadIcon(Request $request)
    {
        $request->validate([
            'icon' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'id'   => 'nullable|exists:faith_milestones,id'
        ]);

        $faithMilestone = FaithMilestone::find($request->id);

        if ($faithMilestone) {
            $oldIconPath = public_path($faithMilestone->icon);
            if (file_exists($oldIconPath)) {
                unlink($oldIconPath);
            }
        }

        $destinationPath = public_path('images/icons/faith-milestones');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $imageName = 'fm-' . time() . '.' . $request->icon->extension();

        $request->icon->move($destinationPath, $imageName);
        $faithMilestone->update(['icon' => 'images/icons/faith-milestones/' . $imageName]);

        return response()->json(['icon' => 'images/icons/faith-milestones/' . $imageName]);
    }
}
