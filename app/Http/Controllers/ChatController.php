<?php

namespace App\Http\Controllers;

use App\Events\PrivateChatEvent;
use App\Http\Resources\ChatResource;
use App\Models\Session;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Session $session){
       return ChatResource::collection($session->chats->where('user_id', auth()->user()->id));
    }

    public function store(Request $request, Session $session){
        $message = $session->messages()->create(['content' => $request->content]);
        $message->chatForSender($session->id);

        $chat = $message->chatForRecipient($session->id, $request->userTo);

        broadcast(new PrivateChatEvent($chat));
        return $message;
    }
}
