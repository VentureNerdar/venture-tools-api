<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Models\SystemLanguage;
use App\Models\Movement;

class RegistrationController extends Controller
{
    //
    public function getRegistrationOptions()
    {
        $languages = SystemLanguage::all();
        $movements = Movement::all();

        return response()->json([
            'languages' => $languages,
            'movements' => $movements
        ]);
    }

    public function register(UserRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }
}
