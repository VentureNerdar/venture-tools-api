<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Models\User;
use App\Models\Setting;
use App\Services\NotificationService;
use App\Services\CRUDService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    protected $notificationService;
    protected $crudService;
    protected $model;

    public function __construct(NotificationService $notificationService, CRUDService $crudService)
    {
        $this->notificationService = $notificationService;
        $this->crudService = $crudService;
        $this->model = Setting::class;
    }

    /**
     * Create a new notification setting
     */
    public function create(NotificationRequest $request)
    {
        return response()->json(...$this->crudService->save($this->model, null, $request->validated()));
    }

    /**
     * Update an existing notification setting
     */
    public function update(NotificationRequest $request, $id)
    {
        return response()->json(...$this->crudService->save($this->model, $id, $request->validated()));
    }

    /**
     * Browse notification settings
     */
    public function browse(Request $request)
    {
        return response()->json(...$this->crudService->browse($this->model, $request));
    }

    /**
     * Register a new notification token
     */
    public function registerToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'device_mac_address' => 'nullable|string|max:17',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $token = $this->notificationService->registerToken(
                Auth::user(),
                $request->token,
                $request->device_mac_address,
                $request->latitude,
                $request->longitude
            );

            return response()->json(['message' => 'Token registered successfully', 'token' => $token], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to register token', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove a notification token
     */
    public function removeToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $this->notificationService->removeToken($request->token);
            return response()->json(['message' => 'Token removed successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to remove token', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get all tokens for the authenticated user
     */
    public function getTokens()
    {
        try {
            $tokens = $this->notificationService->getUserTokens(Auth::user());
            return response()->json(['tokens' => $tokens]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to get tokens', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Send a notification to a specific user
     */
    public function sendToUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $user = User::findOrFail($request->user_id);
            $this->notificationService->sendToUser(
                $user,
                $request->title,
                $request->body,
                $request->data ?? []
            );

            return response()->json(['message' => 'Notification sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send notification', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Send a notification to multiple users
     */
    public function sendToUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'title' => 'required|string',
            'body' => 'required|string',
            'data' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $users = User::whereIn('id', $request->user_ids)->get();
            $this->notificationService->sendToUsers(
                $users,
                $request->title,
                $request->body,
                $request->data ?? []
            );

            return response()->json(['message' => 'Notifications sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send notifications', 'error' => $e->getMessage()], 500);
        }
    }
}
