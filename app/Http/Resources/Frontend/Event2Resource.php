<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class Event2Resource extends JsonResource
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
            'id'         => $this->id,
            'image'      => ($this->image) ? request()->root() .'/uploads/' . $this->image->url : NULL,
            'background' => ($this->bgImage) ? request()->root() .'/uploads/' . $this->bgImage->url : NULL,

            'bgTitle'  => $this->bgTitle,
            'bgColor'  => $this->bgColor,
            'bgHint'   => $this->bgHint,
            
            'body1'    => $this->body1,
            'body2'    => $this->body2,
            'body3'    => $this->body3,
            'body4'    => $this->body4,
            'body5'    => $this->body5,
            'body6'    => $this->body6,
            'body7'    => $this->body7,
            'body8'    => $this->body8,
            'body9'    => $this->body9,
            'body10'   => $this->body10,
            'body11'   => $this->body11,
            'body12'   => $this->body12,
            'body13'   => $this->body13,
            'body14'   => $this->body14,
            'body15'   => $this->body15,
            'body16'   => $this->body16,
            'body17'   => $this->body17,
            'body18'   => $this->body18,
        ];
    }
}
