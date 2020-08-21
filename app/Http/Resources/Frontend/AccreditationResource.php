<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class AccreditationResource extends JsonResource
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
            'image'         => ($this->image) ? request()->root() . $this->image->url : NULL,
            'slug'          => $this->slug,
            'title'         => $this->title,
            'body'          => $this->body,
            'has_faq'       => (boolean)$this->has_faq,
            'has_training'  => (boolean)$this->has_training,
        ];
    }
}
