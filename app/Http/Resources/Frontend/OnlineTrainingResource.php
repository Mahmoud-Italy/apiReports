<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class OnlineTrainingResource extends JsonResource
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
            'image'         => ($this->image) ? request()->root() . '/uploads/' . $this->image->url : NULL,
            'bgTitle'       => $this->bgTitle,
            'bgColor'       => $this->bgColor,
            'slug'          => $this->slug,
            'title'         => $this->title,
            'body'          => $this->body,
            'has_member'    => (boolean)$this->has_member,
        ];
    }
}
