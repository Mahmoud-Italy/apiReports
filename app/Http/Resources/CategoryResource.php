<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'icon'          => ($this->icon) ?? NULL,
            'meta'          => ($this->meta) ?? NULL,
            'user'          => ($this->user) ?? NULL,

            'parent_id'     => $this->parent_id,
            'slug'          => $this->slug,
            'title'         => $this->title,
            'body'          => $this->body,
            'color'         => $this->color,

            'dateForHumans' => $this->created_at->diffForHumans(),
            'timestamp'     => $this->created_at,

            'status'        => (boolean)$this->status,
            'trash'         => (boolean)$this->trash
        ];
    }
}
