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
        $content[] = [
            'body'        => $this->body1_1,
            'background'  => ($this->image1_1) ? request()->root() . '/uploads/' . $this->image1_1->url : NULL,
            
            'body_left'   => $this->body2_1,
            'body_right'  => $this->body2_1_r,
            'image'       => ($this->image2_1) ? request()->root() . '/uploads/' . $this->image2_1->url : NULL,
            'label'       => $this->label2_1,
            'color'       => $this->color2_1,
            'image_dir'   => 'right',
        ];

        $content[] = [
            'body'        => $this->body1_2,
            'background'  => ($this->image1_2) ? request()->root() . '/uploads/' . $this->image1_2->url : NULL,

            'body_left'   => $this->body2_2,
            'body_right'  => $this->body2_2_r,
            'image'       => ($this->image2_2) ? request()->root() . '/uploads/' . $this->image2_2->url : NULL,
            'label'       => $this->label2_2,
            'color'       => $this->color2_2,
            'image_dir'   => 'left',
        ];

        $content[] = [
            'body'        => $this->body1_3,
            'background'  => ($this->image1_3) ? request()->root() . '/uploads/' . $this->image1_3->url : NULL,
                    
            'body_left'   => $this->body2_3,
            'body_right'  => $this->body2_3_r,
            'image'       => ($this->image2_3) ? request()->root() . '/uploads/' . $this->image2_3->url : NULL,
            'label'       => $this->label2_3,
            'color'       => $this->color2_3,
            'image_dir'   => 'right',
        ];

        $content[] = [
            'body'        => $this->body1_4,
            'background'  => ($this->image1_4) ? request()->root() . '/uploads/' . $this->image1_4->url : NULL,
            
            'body_left'   => $this->body2_4,
            'body_right'  => $this->body2_4_r,
            'image'       => ($this->image2_4) ? request()->root() . '/uploads/' . $this->image2_4->url : NULL,
            'label'       => $this->label2_4,
            'color'       => $this->color2_4,
            'image_dir'   => 'left',
        ];

    }
}
