<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $with = ['message'];

    public function message() {
       return $this->belongsTo(Message::class);
    }

    public function markAsRead(){
       return $this->update(['read_at' => now()]);
    }
}
