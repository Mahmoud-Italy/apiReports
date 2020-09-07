<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeResource extends JsonResource
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
            'id'       => $this->id,
            'image'    => ($this->image) ? request()->root() .'/uploads/' . $this->image->url : NULL,

            'title'    => $this->body1,
            'body'     => $this->body3,
            'button'   => $this->body2,
        ];
    }
}
