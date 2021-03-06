<?php

namespace App\Http\Controllers;

use App\Events\SessionEvent;
use App\Http\Resources\SessionResource;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function store(Request $request){
        $session = Session::create([
            'user1_id' => auth()->user()->id,
            'user2_id' => $request->friend_id,
        ]);
        $modifiedSession = new SessionResource($session);
        broadcast(new SessionEvent($modifiedSession, auth()->user()->id));
        return $modifiedSession;
    }
}
