<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        // Check if current password matches
        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'errors' => ['Current password is incorrect'],
                'message' => ['Current password is incorrect'],
            ], 422);
        }

        // Update to new password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password changed successfully'], 200);
    }
}
