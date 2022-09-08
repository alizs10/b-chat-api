<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $inputs = $request->all();
        $user->update($inputs);

        return response()->json([
            'user' => $user,
            'status' => true,
        ]);
    }
}
