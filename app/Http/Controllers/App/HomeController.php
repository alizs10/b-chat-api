<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function checkUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/g|min:6|max:25'
        ]);
        $requestedUser = User::where("username", $request->username)->first();
        $usernameExists = empty($requestedUser) ? true : false;

        $user = Auth::user();
        if ($usernameExists && $user->username === $requestedUser->username) {
            return response()->json([
                'status' => false,
                'error' => "can't start a conversation with your self!"
            ]);
        }
        
        return response()->json([
            'status' => $usernameExists
        ]);
    }
}
