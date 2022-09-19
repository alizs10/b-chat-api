<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\SettingsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function userProfile(User $user)
    {
        return response()->json([
            'status' => true,
            'user' => $user->only('username', 'name', 'bio', 'profile_photo')
        ]);
    }

    public function getSettings()
    {
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'settings' => $user->settings->only('private_account', 'invite_to_groups', 'always_offline', 'dark_theme')
        ]);
    }

    public function updateSettings(SettingsRequest $request)
    {
        $user = Auth::user();
        $updatable = $request->except('_method');
        $user->settings()->update($updatable);
        
        return response()->json([
            'status' => true,
            'settings' => $user->settings->only('private_account', 'invite_to_groups', 'always_offline', 'dark_theme')
        ]);
    }
}
