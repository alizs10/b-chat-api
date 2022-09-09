<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function initial()
    {
        $user = Auth::user();
        $conversations = $user->conversations;

        return response()->json([
            'conversations' => $conversations
        ]);
    }
}
