<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversationHistory extends Model
{
    protected $table = 'conversation_history';

    protected $fillable = [
        'user_id',
        'question',
        'response',
        'session_id'
    ];
}
