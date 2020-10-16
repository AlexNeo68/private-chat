<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function session () {
       return $this->belongsTo(Session::class);
    }

    public function chats() {
       return $this->hasMany(Chat::class);
    }


    public function chatForSender($sessionId){
        return $this->chats()->create([
            'session_id' => $sessionId,
            'user_id' => auth()->user()->id,
            'type' => 0,
        ]);
    }

    public function chatForRecipient($sessionId, $userTo){
        return $this->chats()->create([
            'session_id' => $sessionId,
            'user_id' => $userTo,
            'type' => 1,
        ]);
    }

}
