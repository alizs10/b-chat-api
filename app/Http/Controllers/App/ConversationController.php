<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Services\ConversationService;
use App\Models\Conversation;
use App\Models\User;
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
        $messages = $conversation->messages()->orderBy('id', 'desc')->with('parent')->get();
        foreach($messages as $msg)
        {
            $msg->update(['seen' => 1]);
        }

        return response()->json([
            'status' => true,
            'messages' => $messages
        ]);
    }

    public function checkUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|regex:/^[A-Za-z0-9]+(?:[ _-][A-Za-z0-9]+)*$/|min:6|max:25'
        ]);
        $user = Auth::user();
        $requestedUser = User::where("username", $request->username)
        ->where("username", '!=', $user->username)
        ->first();
        $usernameExists = empty($requestedUser) ? false : true;

        // check if its an private account
        if (!$usernameExists || $requestedUser->settings->private_account == 1) {
            if ($user->username === $request->username) {
                $errorMsg = "can't start a conversation with your self!";
            } else {
                $errorMsg = "could'nt find any user";
            }

            return response()->json([
                'status' => false,
                'error' => $errorMsg
            ]);
        }

        
        

        $conversationService = new ConversationService($user->username, $request->username);
        $result = $conversationService->create();

        return response()->json([
            'status' => $usernameExists,
            'result' => $result
        ]);
    }
}
