<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'image'         => ($this->image) ? request()->root() .'/uploads/' . $this->image->url : NULL,
            'image2'         => ($this->image2) ? request()->root() .'/uploads/' . $this->image2->url : NULL,
            'bgTitle'       => $this->bgTitle,
            'bgSubTitle'    => $this->bgSubTitle,
            'bgColor'       => $this->bgColor,
            'title'         => $this->title,

            'body1'         => $this->body1,
            'body2'         => $this->body2,
            'body3'         => $this->body3,
            'body4'         => $this->body4,
            'body5'         => $this->body5,
            'body6'         => $this->body6,
        ];
    }
}
