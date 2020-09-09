<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
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
            

            'bgTitle'        => $this->bgTitle,
            'bgColor'        => $this->bgColor,
            'body1'          => $this->body1,
            'has_download'   => (int)$this->has_download,
            'download_name'  => $this->download_name,
            'pdf_file'       => ($this->image_pdf) ? request()->root() . '/uploads/' . $this->image_pdf->url : NULL,

            'title2_1'       => $this->title2_1,
            'title2_2'       => $this->title2_2,
            'body2_1'        => $this->body2_1,
            'video2_2'       => $this->video2_2,

            'title3_1'       => $this->title3_1,
            'title3_2'       => $this->title3_2,
            'body3_1'        => $this->body3_1,
            'body3_2'        => $this->body3_2,


            'title4_1'       => $this->title4_1,
            'title4_2'       => $this->title4_2,
            'body4_1'        => $this->body4_1,
            'body4_2'        => $this->body4_2,

            'title5_1'       => $this->title5_1,
            'title5_2'       => $this->title5_2,
            'body5_1'        => $this->body5_1,
            'image5_2'       => ($this->image5_2) ? request()->root() . '/uploads/' . $this->image5_2->url : NULL,
            'body5_3'        => $this->body5_3,
            'body5_4'        => $this->body5_4,
        ];

    }
}
