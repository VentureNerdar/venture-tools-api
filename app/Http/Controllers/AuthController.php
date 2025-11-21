<?php

namespace App\Http\Controllers;

use App\Models\ChurchPlanter;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|min:8',
            'platform' => 'required|string|in:mobile,web',
        ]);

        $user = User::where('email', $request->identifier)
            ->orWhere('phone_number', $request->identifier)
            // ->orWhere('username', $request->identifier)
            ->first();

        // User not found
        if (! $user) {
            return response([
                'message' => ['User not found'],
            ], 422);
        }

        // If Mobile
        // if ($request->platform === 'mobile') {
        //     // if user not church planter / deciple maker
        //     if ($user->user_role_id !== 4) {
        //         return response([
        //             'message' => ['Only Disciple Makers are to use from mobile platform.'],
        //         ], 422);
        //     }
        // }

        // Wrong Password
        if (! Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.'],
            ], 422);
        }

        $token = $user->createToken('my-app-token')->plainTextToken;

        $user->update(['last_login_at' => now()]);

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        UserDevice::where('user_id', $user->id)
            ->where('device_id', $request->device_id)
            ->forceDelete();
        $user->tokens()->delete();

        $response = [
            'message' => 'logged out',
        ];

        return response($response);
    }

    public function getUser(Request $request)
    {
        $user = $request->user();

        // get planted church
        $user->plantedChurch = ChurchPlanter::whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })
            ->with(['church'])
            ->distinct()
            ->get()
            ->pluck('church')
            ->filter()
            ->unique('id')
            ->values();

        $user->load('devices');

        return response()->json($user, 200);
    }
}
