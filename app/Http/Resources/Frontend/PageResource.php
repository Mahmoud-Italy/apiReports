<?php

namespace App\Http\Resources\Frontend;

use App\Http\Resources\Backend\ImageableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'encrypt_id'    => encrypt($this->id),
            'image'         => ($this->image) ? (new ImageableResource($this->image))->foo('pages') : NULL,
            'meta'          => ($this->meta) ?? NULL,
            
            'title'         => $this->title,
            'slug'          => $this->slug,
            'body'          => $this->body
        ];
    }
}
