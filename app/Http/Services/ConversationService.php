<?php

namespace App\Http\Services;

use App\Models\Conversation;
use App\Models\User;

class ConversationService
{
    protected $status = true;
    protected $message = "";
    protected $error = false;
    protected $conversation;
    protected $first_username;
    protected $second_username;
    protected $users;

    public function __construct($first_username, $second_username)
    {
        $this->first_username = $first_username;
        $this->second_username = $second_username;
        $this->setUsers();
    }

    public function create()
    {
        // returns false if we have invalid usernames or users already have an active conversation 
        $result = $this->verify();
        if (!$result) return  $this->response();

        // create new conversation
        $new_conversation = Conversation::create();
        $new_conversation->users()->attach([$this->users['first_user']->id, $this->users['second_user']->id]);
        $this->setResponse(true, false, "new conversation created successfully", $new_conversation);
        return $this->response();
    }

    private function verify()
    {
        // check for possible errors in setting users
        if ($this->error) return false;

        $first_user = $this->users['first_user'];
        $second_user = $this->users['second_user'];
        $first_user_conversations = $first_user->conversations;

        //check if they already have an active conversation
        foreach ($first_user_conversations as $conversation) {
            $users = $conversation->users;
            foreach ($users as $user) {
                if ($user->username === $second_user->username) {
                    $this->setResponse(true, false, "already have an active conversation", $conversation);
                    return false;
                }
            }
        }

        return true;
    }

    public function setUsers()
    {
        $first_user = User::where('username', $this->first_username)->first();
        $second_user = User::where('username', $this->second_username)->first();

        if (empty($first_user) || empty($second_user)) {
            $this->setResponse(true, true, "invalid username ($this->first_username or $this->second_username)", null);
        }

        $this->users = [
            "first_user" => $first_user,
            "second_user" => $second_user,
        ];
    }

    private function response()
    {
        return [
            "status" => $this->status,
            "error" => $this->error,
            "message" => $this->message,
            "conversation" => $this->conversation,
        ];
    }

    private function setResponse($status, $error, $message = null, $conversation = null)
    {
        $this->status = $status;
        $this->error = $error;
        $this->message = $message;
        $this->conversation = $conversation;
    }
}
