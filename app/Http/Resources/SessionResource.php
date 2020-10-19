<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
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
            'open' => false,
            'blocked' => !!$this->blocked,
            'blocked_by' => $this->blocked_by,
            'open' => false,
            'users' => [$this->user1_id, $this->user2_id],
            'unreadMessageCount' => $this->chats()
                ->where('read_at', null)
                ->where('type', 0)
                ->whereNotIn('user_id', [auth()->user()->id])
                ->count()
        ];
    }
}
