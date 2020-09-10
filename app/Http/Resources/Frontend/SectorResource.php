<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class SectorResource extends JsonResource
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
            'download_file'  => ($this->pdf) ? request()->root() .'/uploads/' . $this->pdf->url : NULL,
            'download_image' => ($this->pdf_image) ? request()->root() .'/uploads/' . $this->pdf_image->url : NULL,
            'download_name'  => $this->download_name,
            'slug'          => $this->slug,
            'title'         => $this->title,
            'body'          => $this->body,
            //'childs'        => count($this->childs)
        ];
    }
}
