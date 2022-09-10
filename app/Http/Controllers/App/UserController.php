<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userProfile(User $user)
    {
        return response()->json([
            'status' => true,
            'user' => $user->only('username', 'name', 'bio', 'profile_photo')
        ]);
    }
}
