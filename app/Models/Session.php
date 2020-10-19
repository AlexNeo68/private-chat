<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function chats(){
       return $this->hasManyThrough(Chat::class, Message::class);
    }

    public function messages(){
       return $this->hasMany(Message::class);
    }

    public function removeChatsAuthUser(){
       return $this->chats()->where('user_id', auth()->user()->id)->delete();
    }

    public function removeMessages(){
       return $this->messages()->delete();
    }

    public function block(){
        $this->blocked = 1;
        $this->blocked_by = auth()->user()->id;
        $this->save();
        return $this;
    }

    public function unBlock(){
        $this->blocked = 0;
        $this->blocked_by = null;
        $this->save();
        return $this;
    }

}
