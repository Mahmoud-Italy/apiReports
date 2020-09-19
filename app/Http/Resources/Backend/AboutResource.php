<?php

namespace App\Http\Resources\Backend;

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
            'encrypt_id'    => encrypt($this->id),
            'image'         => ($this->image) ? request()->root() . '/uploads/' . $this->image->url : NULL,
            
            'slug'          => $this->slug,
            'title'         => $this->title,
            
            'bgTitle'        => $this->bgTitle,
            'bgColor'        => $this->bgColor,
            'body1'          => $this->body1,
            'has_download'   => (int)$this->has_download,
            'download_name'  => $this->download_name,
            'download_file'  => ($this->pdf) ? request()->root() . '/uploads/' . $this->pdf->url : NULL,
            'download_image'  => ($this->image_pdf) ? request()->root() . '/uploads/' . $this->image_pdf->url : NULL,

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
            'image5_1'       => ($this->image5_1) ? request()->root() . '/uploads/' . $this->image5_1->url : NULL,
            'read5_1'        => $this->read5_1,

            'body5_2'        => $this->body5_2,
            'image5_2'       => ($this->image5_2) ? request()->root() . '/uploads/' . $this->image5_2->url : NULL,
            'read5_2'        => $this->read5_2,

            'body5_3'        => $this->body5_3,
            'image5_3'       => ($this->image5_3) ? request()->root() . '/uploads/' . $this->image5_3->url : NULL,
            'read5_3'        => $this->read5_3,

            'body5_4'        => $this->body5_4,
            'image5_4'       => ($this->image5_4) ? request()->root() . '/uploads/' . $this->image5_4->url : NULL,
            'read5_4'        => $this->read5_4,

            'body5_5'        => $this->body5_5,
            'image5_5'       => ($this->image5_5) ? request()->root() . '/uploads/' . $this->image5_5->url : NULL,
            'read5_5'        => $this->read5_5,

            'body5_6'        => $this->body5_6,
            'image5_6'       => ($this->image5_6) ? request()->root() . '/uploads/' . $this->image5_6->url : NULL,
            'read5_6'        => $this->read5_6,

            'body5_7'        => $this->body5_7,
            'image5_7'       => ($this->image5_7) ? request()->root() . '/uploads/' . $this->image5_7->url : NULL,
            'read5_7'        => $this->read5_7,

            'body5_8'        => $this->body5_8,
            'image5_8'       => ($this->image5_8) ? request()->root() . '/uploads/' . $this->image5_8->url : NULL,
            'read5_8'        => $this->read5_8,



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
            
            'has_application'  => (int)$this->has_application,
            'application_name' => $this->application_name,
            'application_path' => $this->application_path,
            
            'has_download'  => (int)$this->has_download,
            'status'        => (int)$this->status,
            'trash'         => (int)$this->trash,
            'loading'       => false
        ];
    }
}
