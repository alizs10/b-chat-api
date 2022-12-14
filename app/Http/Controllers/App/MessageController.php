<?php

namespace App\Http\Controllers\App;

use App\Events\Chat\Message as ChatMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $inputs = $request->all();
        $message = Message::create($inputs);
        $message->load('parent', 'conversation');

        event(new ChatMessage($message));

        return response()->json([
            'message' => $message,
        ]);
    }

    public function update(Request $request, Message $message)
    {
        $inputs = $request->all();
        $inputs['is_edited'] = true;
        $message->update($inputs);
        return response()->json([
            'message' => $message,
        ]);
    }

    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json(null, 201);
    }
}
