<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
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
            'id'            => $this->id,
            //'encrypt_id'    => encrypt($this->id),
            
            'image'         => ($this->image) ?? NULL,
            'meta'          => ($this->meta) ?? NULL,
            'user'          => ($this->user) ?? NULL,

            'slug'          => $this->slug,
            'title'         => $this->title,
            'body'          => $this->body,

            'dateForHumans' => $this->created_at->diffForHumans(),
            'timestamp'     => $this->created_at,

            'status'        => (boolean)$this->status,
            'trash'         => (boolean)$this->trash
        ];
    }
}
