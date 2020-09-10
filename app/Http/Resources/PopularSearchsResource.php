<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PopularSearchResource extends JsonResource
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
            'encrypt_id'    => encrypt($this->id),
            'image'         => ($this->image) ? request()->root() .'/uploads/' . $this->image->url : NULL,
            'download_file' => ($this->pdf) ? request()->root() .'/uploads/' . $this->pdf->url : NULL,

            'download_image' => ($this->image_pdf) ? request()->root() .'/uploads/' . $this->image_pdf->url : NULL,

            'slug'          => $this->slug,
            'title'         => $this->title,
            'body'          => $this->body,

            'bgTitle'       => $this->bgTitle,
            'bgColor'       => $this->bgColor,


            'body1'         => $this->body1,
            'body2'         => $this->body2,
            'body3'         => $this->body3,
            'body4'         => $this->body4,
            'body5'         => $this->body5,


            // 1
            'body1_1'         => $this->body1_1,
            'image1_1'        => ($this->image1_1) ? request()->root() .'/uploads/' . $this->image1_1->url : NULL,
            'body1_2'         => $this->body1_2,
            'image1_2'        => ($this->image1_2) ? request()->root() .'/uploads/' . $this->image1_2->url : NULL,
            'body1_3'         => $this->body1_3,
            'image1_3'        => ($this->image1_3) ? request()->root() .'/uploads/' . $this->image1_3->url : NULL,
            'body1_4'         => $this->body1_4,
            'image1_4'        => ($this->image1_4) ? request()->root() .'/uploads/' . $this->image1_4->url : NULL,
            // 2
            'body2_1'         => $this->body2_1,
            'body2_1_r'         => $this->body2_1_r,
            'image2_1'        => ($this->image2_1) ? request()->root() .'/uploads/' . $this->image2_1->url : NULL,
            'label2_1'        => $this->label2_1,
            'color2_1'        => $this->color2_1,

            'body2_2'         => $this->body2_2,
            'body2_2_r'         => $this->body2_2_r,
            'image2_2'        => ($this->image2_2) ? request()->root() .'/uploads/' . $this->image2_2->url : NULL,
            'label2_2'        => $this->label2_2,
            'color2_2'        => $this->color2_2,

            'body2_3'         => $this->body2_3,
            'body2_3_r'         => $this->body2_3_r,
            'image2_3'        => ($this->image2_3) ? request()->root() .'/uploads/' . $this->image2_3->url : NULL,
            'label2_3'        => $this->label2_3,
            'color2_3'        => $this->color2_3,

            'body2_4'         => $this->body2_4,
            'body2_4_r'         => $this->body2_4_r,
            'image2_4'        => ($this->image2_4) ? request()->root() .'/uploads/' . $this->image2_4->url : NULL,
            'label2_4'        => $this->label2_4,
            'color2_4'        => $this->color2_4,

            // Dates
            'dateForHumans' => $this->created_at->diffForHumans(),
            'created_at'    => ($this->created_at == $this->updated_at) 
                                ? 'Created <br/>'. $this->created_at->diffForHumans()
                                : NULL,
            'updated_at'    => ($this->created_at != $this->updated_at) 
                                ? 'Updated <br/>'. $this->updated_at->diffForHumans()
                                : NULL,
            'deleted_at'    => ($this->updated_at && $this->trash) 
                                ? 'Deleted <br/>'. $this->updated_at->diffForHumans()
                                : NULL,
            'timestamp'     => $this->created_at,


            // Status & Visibility
            'download_name' => $this->download_name,
            'sort'          => (int)$this->sort,
            'has_faq'       => (int)$this->has_faq,
            'has_training'  => (int)$this->has_training,
            'has_download'  => (int)$this->has_download,
            
            'status'        => (boolean)$this->status,
            'trash'         => (boolean)$this->trash,
            'loading'       => false
        ];
    }
}
