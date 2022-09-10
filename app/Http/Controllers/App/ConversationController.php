<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = $user->conversations;
        return response()->json([
            'status' => true,
            'conversations' => $conversations
        ]);
    }

    public function messages(Conversation $conversation)
    {
        $messages = $conversation->messages()->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => true,
            'messages' => $messages,
        ]);
    }
}
