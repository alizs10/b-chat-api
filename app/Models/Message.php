<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'body',
        'user_id',
        'conversation_id',
        'parent_id',
        'seen',
        'is_edited',
        'status',
    ];


    protected $appends = ['writer'];

    protected function writer(): Attribute
    {
        return Attribute::make(
            get: fn ()  => $this->user()->select('id', 'username', 'profile_photo', 'name', 'user_status')->first(),
        );
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id', 'id');
    }
}
