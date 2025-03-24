<?php

namespace App\Http\Controllers;

use App\Models\ChurchPlanter;
use App\Models\User;
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
            'email' => 'required|string|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
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

    public function logout()
    {
        auth()->user()->tokens()->delete();

        $response = [
            'message' => 'logged out',
        ];

        return response($response);
    }

    public function getUser(Request $request)
    {
        $user = $request->user();

        // get planted church
        $church = ChurchPlanter::whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        })
            ->with(['church'])
            ->distinct()
            ->get()
            ->pluck('church')
            ->filter()
            ->unique('id')
            ->values();

        $user->plantedChurch = $church;

        return response()->json($user, 200);
    }
}
