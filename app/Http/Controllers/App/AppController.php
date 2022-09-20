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
        $conversations = $user->conversations->sort(function ($a, $b) {
            if ($a->last_message && $b->last_message) {
                return $a->last_message->created_at < $b->last_message->created_at;
            } else {
                if (!$a->last_message && !$b->last_message)
                {
                    return $a->created_at < $b->created_at;
                }
                if($a->last_message)
                {
                    return false;
                } else {
                    return true;
                }
                
            }
        })->values()->all();

        return response()->json([
            'conversations' => $conversations,
            'settings' => $user->settings->only('private_account', 'invite_to_groups', 'always_offline', 'dark_theme')
        ]);
    }
}
