<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListRequest;
use Illuminate\Http\Request;
use App\Services\CRUDService;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Http\Requests\DeviceRequest;
use Illuminate\Support\Facades\Request as RequestFacade;

class UserController extends Controller
{
    protected $service;
    protected $model;

    public function __construct(CRUDService $service)
    {
        $this->service = $service;
        $this->model = User::class;
    }

    public function create(UserRequest $request)
    {
        return response()->json(...$this->service->save($this->model, null, $request->validated()));
    }

    public function update(UserRequest $request, $id)
    {
        return response()->json(...$this->service->save($this->model, $id, $request->validated()));
    }

    public function browse(Request $request)
    {
        return response()->json(...$this->service->browse($this->model, $request));
    }

    public function list(ListRequest $request)
    {
        $data = $request->validated();
        return response()->json(...$this->service->list($this->model, $data['labelOption'] ?? null, $data['limit'] ?? 10));
    }

    public function view($id)
    {
        // return $this->service->browse($this->model, null, $id);
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

    /**
     * Get all devices for a user
     */
    public function getDevices($id)
    {
        $user = User::findOrFail($id);
        $devices = $user->devices()
            ->select(['id', 'device_id', 'device_type', 'device_name', 'last_active_at', 'last_ip_address'])
            ->get();

        return response()->json(['devices' => $devices]);
    }

    /**
     * Remove a specific device
     */
    public function removeDevice($id, $deviceId)
    {
        $user = User::findOrFail($id);
        $device = $user->devices()->where('device_id', $deviceId)->firstOrFail();

        // If this is the current device, revoke its token
        if ($device->notification_token) {
            $device->update(['notification_token' => null]);
        }

        $device->delete();

        return response()->json(['message' => 'Device removed successfully']);
    }

    /**
     * Remove all devices except the current one
     */
    public function removeOtherDevices($id, Request $request)
    {
        $user = User::findOrFail($id);
        $currentDeviceId = $request->header('X-Device-ID');

        if (!$currentDeviceId) {
            return response()->json(['message' => 'Current device ID is required'], 400);
        }

        $user->devices()
            ->where('device_id', '!=', $currentDeviceId)
            ->delete();

        return response()->json(['message' => 'Other devices removed successfully']);
    }

    /**
     * Update device information
     */
    public function updateDevice(DeviceRequest $request, $id, $deviceId)
    {
        $user = User::findOrFail($id);
        $device = $user->devices()->where('device_id', $deviceId)->firstOrFail();
        $data = $request->validated();

        $device->update([
            'device_name' => $data['device_name'],
            'device_type' => $data['device_type'],
            'notification_token' => $data['notification_token'] ?? $device->notification_token,
            'last_ip_address' => $data['last_ip_address'] ?? RequestFacade::ip(),
            'last_active_at' => now()
        ]);

        return response()->json([
            'message' => 'Device updated successfully',
            'device' => $device
        ]);
    }

    /**
     * Register a new device for a user
     */
    public function registerDevice(DeviceRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();

        // Check if device already exists
        $device = $user->devices()->where('device_id', $data['device_id'])->first();

        if ($device) {
            // Update existing device
            $device->update([
                'device_name' => $data['device_name'],
                'device_type' => $data['device_type'],
                'notification_token' => $data['notification_token'] ?? null,
                'last_ip_address' => $data['last_ip_address'] ?? RequestFacade::ip(),
                'last_active_at' => now()
            ]);
        } else {
            // Create new device
            $device = $user->devices()->create([
                'device_id' => $data['device_id'],
                'device_name' => $data['device_name'],
                'device_type' => $data['device_type'],
                'notification_token' => $data['notification_token'] ?? null,
                'last_ip_address' => $data['last_ip_address'] ?? RequestFacade::ip(),
                'last_active_at' => now()
            ]);
        }

        return response()->json([
            'message' => 'Device registered successfully',
            'device' => $device
        ], 201);
    }
}
