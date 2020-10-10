<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
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
            'slug'          => $this->slug,
            'title'         => $this->title,
            'subtitle'      => $this->subtitle,
            'short_body'    => $this->short_body,
            //'body'          => $this->body,


            'bgTitle'       => $this->bgTitle,
            'bgColor'       => $this->bgColor,

            'title1'         => $this->title1,
            'title2'         => $this->title2,
            'title3'         => $this->title3,
            'title4'         => $this->title4,
            'title5'         => $this->title5,

            'body1'         => $this->body1,
            'body2'         => $this->body2,
            'body3'         => $this->body3,
            'body4'         => $this->body4,
            'body5'         => $this->body5,
            'body6'         => $this->body6,

            'download_file' => ($this->pdf) ? request()->root() .'/uploads/' . $this->pdf->url : NULL,
            'download_image' => ($this->image_pdf) ? request()->root() .'/uploads/' . $this->image_pdf->url : NULL,
            'download_name'  => $this->download_name,
        ];
    }
}
