<?php

namespace App\Models;

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

    public function conversation()
    {
        $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function parent()
    {
        $this->belongsTo($this, 'parent_id', 'id');
    }

    public function child()
    {
        $this->hasOne($this, 'parent_id', 'id');
    }
}
