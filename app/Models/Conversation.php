<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use HasFactory;

    protected $appends = ['with_user', 'last_message'];

    protected function withUser(): Attribute
    {
        return Attribute::make(
            get: fn ()  => $this->users()->where('id', '!=', auth()->user()->id)->select('username', 'profile_photo', 'name')->first(),
        );
    }

    protected function lastMessage(): Attribute
    {
        return Attribute::make(
            get: fn ()  => $this->messages()->latest('created_at')->first(),
        );
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->using(ConversationUser::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
