<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovementNotificationRequest;
use App\Models\MovementNotification;
use App\Services\CRUDService;
use Illuminate\Http\Request;

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
        $movementNotification = $this->service->save($this->model, null, $request->all())[0];
        return response()->json($movementNotification, 201);
    }
}
