<?php

namespace App\Http\Resources;

use App\Models\Session;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'online' => false,
            'session' => $this->getSession($this->id)
        ];
    }

    protected function getSession($id){
        $session = Session::whereIn('user1_id', [$id, auth()->user()->id])
            ->whereIn('user2_id', [$id, auth()->user()->id])
            ->first();
        return new SessionResource($session);
    }
}
