<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
    use HasFactory;

    protected $table = "live";

    protected $fillable = [
        'title', 'description', 'type', 'status', 'token', 'chat', 'onLive', 'schedule_at', 'started_at', 'ended_at', 'created_by', 'created_at', 'updated_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'live_id', 'id');
    }
}
