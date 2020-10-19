<?php

namespace App\Http\Controllers;

use App\Events\SessionBlockEvent;
use App\Models\Session;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    public function block( Session $session ){
        broadcast(new SessionBlockEvent($session->id, true));
        return $session->block();
    }

    public function unblock( Session $session ){
        if(auth()->user()->id !== $session->blocked_by){
            return abort(403, 'Unblock session can only who ther blocked!');
        }
        broadcast(new SessionBlockEvent($session->id, false));
        return $session->unBlock();
    }
}
