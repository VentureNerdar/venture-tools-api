<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use App\Models\Setting;
use App\Services\CRUDService;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $service;

    protected $model;

    protected $firebaseService;

    public function __construct(CRUDService $service, FirebaseService $firebaseService)
    {
        $this->service = $service;
        $this->model = Setting::class;
        $this->firebaseService = $firebaseService;
    }

    public function create(NotificationRequest $request)
    {
        return response()->json(...$this->service->save($this->model, null, $request->all()));
    }

    public function update(NotificationRequest $request, $id)
    {
        return response()->json(...$this->service->save($this->model, $id, $request->all()));
    }

    public function browse(Request $request)
    {
        return response()->json(...$this->service->browse($this->model, $request));
    }

    // public function sendNotification(Request $request)
    // {
    //     $request->validate([
    //         'token' => 'required|string',
    //         'title' => 'required|string',
    //         'body' => 'required|string',
    //         'data' => 'nullable|array'
    //     ]);

    //     $token = $request->input('token');
    //     $title = $request->input('title');
    //     $body = $request->input('body');
    //     $data = $request->input('data', []);

    //     $this->firebaseService->sendNotification($token, $title, $body);

    //     return response()->json(['message' => 'Notification sent successfully']);
    // }
}
