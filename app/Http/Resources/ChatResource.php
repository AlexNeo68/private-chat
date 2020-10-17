<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'message' => $this->message->content,
            'type' => $this->type,
            'send_at' => $this->get_timing_read_at(),
            'read_at' => optional($this->read_at)->diffForHumans(),
        ];
    }

    protected function get_timing_read_at(){
        return $this->type == 0 ? optional($this->read_at)->diffForHumans() : null;
    }
}
