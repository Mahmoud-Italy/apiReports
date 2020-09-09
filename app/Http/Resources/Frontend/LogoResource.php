<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class LogoResource extends JsonResource
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
            'logo'         => ($this->image) ? request()->root() . '/uploads/' . $this->image->url : NULL,
            'mini_logo'    => ($this->image2) ? request()->root() . '/uploads/' . $this->image2->url : NULL,
        ];

    }
}
