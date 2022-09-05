<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use HasFactory, SoftDeletes;

    public function users()
    {
        $this->belongsToMany(User::class)->withPivot(ConversationUser::class);
    }

    public function messages()
    {
        $this->hasMany(Message::class);
    }

}
