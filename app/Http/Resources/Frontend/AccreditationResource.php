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
        $content[] = ['name' => 'ali'];
        $content[] = ['name' => 'hema'];

        $content->toArray();
        return [
            'id'            => $this->id,
            'image'         => ($this->image) ? request()->root() . $this->image->url : NULL,
            'slug'          => $this->slug,
            'title'         => $this->title,

            'bgTitle'       => $this->bgTitle,
            'bgColor'       => $this->bgColor,
            //'body'          => $this->body,

            'body1'          => $this->body1,
            'body2'          => $this->body2,
            'body3'          => $this->body3,
            'body4'          => $this->body4,
            'body5'          => $this->body5,

            'con'          => $content,
            // 'content' => [{
            //         // d1
            //         'body'        => $this->body1_1,
            //         'background'  => ($this->image1_1) ? request()->root() . $this->image1_1->url : NULL,
                    
            //         // d2
            //         'body_left'   => $this->body2_1,
            //         'body_right'  => $this->body2_1_r,
            //         'image'     => ($this->image2_1) ? request()->root() . $this->image2_1->url : NULL,
            //         'label'     => $this->label2_1,
            //         'color'     => $this->color2_1,
            //         'image_dir' => 'right',
            //     },
            //     {
            //         // d1
            //         'body'   => $this->body1_2,
            //         'image'  => ($this->image1_2) ? request()->root() . $this->image1_2->url : NULL,
                    
            //         // d2
            //         'body_left'   => $this->body2_2,
            //         'body_right'  => $this->body2_2_r,
            //         'image'     => ($this->image2_2) ? request()->root() . $this->image2_2->url : NULL,
            //         'label'     => $this->label2_2,
            //         'color'     => $this->color2_2,
            //         'image_dir' => 'left',
            //     },
            //     {
            //         // d1
            //         'body'   => $this->body1_3,
            //         'image'  => ($this->image1_3) ? request()->root() . $this->image1_3->url : NULL,
                    
            //         // d2
            //         'body_left'   => $this->body2_3,
            //         'body_right'  => $this->body2_3_r,
            //         'image'      => ($this->image2_3) ? request()->root() . $this->image2_3->url : NULL,
            //         'label'      => $this->label2_3,
            //         'color'      => $this->color2_3,
            //         'image_dir'  => 'right',
            //     },
            //     {
            //         // d1
            //         'body'   => $this->body1_4,
            //         'image'  => ($this->image1_4) ? request()->root() . $this->image1_4->url : NULL,
                    
            //         // d2
            //         'body_left'   => $this->body2_4,
            //         'body_right'  => $this->body2_4_r,
            //         'image'     => ($this->image2_4) ? request()->root() . $this->image2_4->url : NULL,
            //         'label'     => $this->label2_4,
            //         'color'     => $this->color2_4,
            //         'image_dir' => 'left',
            //     }
            // ],


            'download_name' => $this->download_name ?? NULL,
            'pdf_file'      => ($this->image_pdf) ? request()->root() . $this->image_pdf->url : NULL,
            'has_faq'       => (boolean)$this->has_faq,
            'has_scroll'    => (boolean)$this->has_scroll,
            'has_training'  => (boolean)$this->has_training,
            'has_download'  => (boolean)$this->has_download,
        ];
    }
}
