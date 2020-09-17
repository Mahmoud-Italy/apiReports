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
            'image'         => ($this->image) ? request()->root() .'/uploads/' . $this->image->url : NULL,
            
            'download_file' => ($this->pdf) 
                                ? request()->root() . '/uploads/' . $this->pdf->url : NULL,
            'download_image' => ($this->image_pdf) 
                                ? request()->root() . '/uploads/' . $this->image_pdf->url : NULL,
            'download_name' => $this->download_name,
            'sort'          => (int)$this->sort,
            'has_faq'       => (int)$this->has_faq,
            'has_download'  => (int)$this->has_download,


            'has_application'  => (int)$this->has_application,
            'application_name' => $this->application_name,
            'application_path' => $this->application_path,



            'slug'          => $this->slug,
            'title'         => $this->title,
            'bgTitle'       => $this->bgTitle,
            'bgColor'       => $this->bgColor,

            // d1
            'body1_1'       => $this->body1_1,

            // d2
            'body2_1'         => $this->body2_1,
            'body2_2'         => $this->body2_2,
            'body2_3'         => $this->body2_3,
            'body2_4'         => $this->body2_4,
            'body2_5'         => $this->body2_5,

            'body2_6'         => $this->body2_6,
            'image2_6'        => ($this->image2_6) 
                                ? request()->root() .'/uploads/' . $this->image2_6->url : NULL,

            'body2_7'         => $this->body2_7,
            'image2_7'        => ($this->image2_7) 
                                ? request()->root() .'/uploads/' . $this->image2_7->url : NULL,

            'body2_8'         => $this->body2_8,
            'image2_8'        => ($this->image2_8) 
                                ? request()->root() .'/uploads/' . $this->image2_8->url : NULL,

            'body2_9'         => $this->body2_9,
            'image2_9'        => ($this->image2_9) 
                                ? request()->root() .'/uploads/' . $this->image2_9->url : NULL,

            'body2_10'        => $this->body2_10,
            'image2_10'       => ($this->image2_10) 
                                ? request()->root() .'/uploads/' . $this->image2_10->url : NULL,

            'body2_11'        => $this->body2_11,
            'image2_11'        => ($this->image2_11) 
                                ? request()->root() .'/uploads/' . $this->image2_11->url : NULL,

            'body2_12'        => $this->body2_12,
            'image2_12'        => ($this->image2_12) 
                                ? request()->root() .'/uploads/' . $this->image2_12->url : NULL,

            'body2_13'        => $this->body2_13,
            'image2_13'        => ($this->image2_13) 
                                ? request()->root() .'/uploads/' . $this->image2_13->url : NULL,

            // d3
            'body3_1'         => $this->body3_1,

            'image3_2'        => ($this->image3_2) 
                                ? request()->root() .'/uploads/' . $this->image3_2->url : NULL,
            'line3_2'         => $this->line3_2,
            'mask3_2'         => $this->mask3_2,
            'color3_2'        => $this->color3_2,
            'body3_2_1'       => $this->body3_2_1,
            'body3_2_2'       => $this->body3_2_2,

            'image3_3'        => ($this->image3_3) 
                                ? request()->root() .'/uploads/' . $this->image3_3->url : NULL,
            'line3_3'         => $this->line3_3,
            'mask3_3'         => $this->mask3_3,
            'color3_3'        => $this->color3_3,
            'body3_3_1'       => $this->body3_3_1,
            'body3_3_2'       => $this->body3_3_2,

            'image3_4'        => ($this->image3_4) 
                                ? request()->root() .'/uploads/' . $this->image3_4->url : NULL,
            'line3_4'         => $this->line3_4,
            'mask3_4'         => $this->mask3_4,
            'color3_4'        => $this->color3_4,
            'body3_4_1'       => $this->body3_4_1,
            'body3_4_2'       => $this->body3_4_2,


            'image3_5'        => ($this->image3_5) 
                                ? request()->root() .'/uploads/' . $this->image3_5->url : NULL,
            'line3_5'         => $this->line3_5,
            'mask3_5'         => $this->mask3_5,
            'color3_5'        => $this->color3_5,
            'body3_5_1'       => $this->body3_5_1,
            'body3_5_2'       => $this->body3_5_2,

            'image3_6'        => ($this->image3_6) 
                                ? request()->root() .'/uploads/' . $this->image3_6->url : NULL,
            'line3_6'         => $this->line3_6,
            'mask3_6'         => $this->mask3_6,
            'color3_6'        => $this->color3_6,
            'body3_6_1'       => $this->body3_6_1,
            'body3_6_2'       => $this->body3_6_2,

            'image3_7'        => ($this->image3_7) 
                                ? request()->root() .'/uploads/' . $this->image3_7->url : NULL,
            'line3_7'         => $this->line3_7,
            'mask3_7'         => $this->mask3_7,
            'color3_7'        => $this->color3_7,
            'body3_7_1'       => $this->body3_7_1,
            'body3_7_2'       => $this->body3_7_2,

            'image3_8'        => ($this->image3_8) 
                                ? request()->root() .'/uploads/' . $this->image3_8->url : NULL,
            'line3_8'         => $this->line3_8,
            'mask3_8'         => $this->mask3_8,
            'color3_8'        => $this->color3_8,
            'body3_8_1'       => $this->body3_8_1,
            'body3_8_2'       => $this->body3_8_2,

            'image3_9'        => ($this->image3_9) 
                                ? request()->root() .'/uploads/' . $this->image3_9->url : NULL,
            'line3_9'         => $this->line3_9,
            'mask3_9'         => $this->mask3_9,
            'color3_9'        => $this->color3_9,
            'body3_9_1'       => $this->body3_9_1,
            'body3_9_2'       => $this->body3_9_2,

            // d4
            'body4_0'         => $this->body4_0,
            'body4_1'         => $this->body4_1,
            'body4_2'         => $this->body4_2,
            'body4_3'         => $this->body4_3,
            'body4_4'         => $this->body4_4,
            'body4_5'         => $this->body4_5,
            'body4_6'         => $this->body4_6,
            'body4_7'         => $this->body4_7,
            'body4_8'         => $this->body4_8,
            'body4_9'         => $this->body4_9,
            'body4_10'        => $this->body4_10,

        ];
    }
}
