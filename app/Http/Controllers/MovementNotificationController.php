<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovementNotificationRequest;
use App\Models\MovementNotification;
use App\Services\CRUDService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class MovementNotificationController extends Controller
{
    protected $service;

    protected $model;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = MovementNotification::class;
    }

    public function create(MovementNotificationRequest $request)

    {
        Log::info($request->all());
        Artisan::call('app:broadcast-movement-notification', [
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);


        $movementNotification = $this->service->save($this->model, null, $request->all())[0];
        return response()->json($movementNotification, 201);
    }


    public function browse(Request $request)
    {
        return response()->json(...$this->service->browse($this->model, $request));
    }

    public function delete($id, Request $request)
    {
        return response()->json(...$this->service->delete($this->model, $id, false));
    }
}
