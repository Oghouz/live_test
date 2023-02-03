<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function live()
    {
        return $this->hasOne(Live::class, 'id', 'live_id');
    }
}
