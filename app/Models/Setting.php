<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = [
        'always_offline',
        'dark_theme',
        'private_account',
        'invite_to_groups',
    ];
}
