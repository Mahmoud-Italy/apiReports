<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            

            'childs'        => count($this->childs),
            'parent_name'   => ($this->parent) ? $this->parent->title : NULL,

            'slug'          => $this->slug,
            'title'         => $this->title,
            'bgTitle'       => $this->bgTitle,
            'bgColor'       => $this->bgColor,

            'body1_1'       => $this->body1_1,

            'image1_2'      => ($this->image1_2) 
                                ? request()->root() .'/uploads/' . $this->image1_2->url : NULL,
            'line1_2'       => $this->line1_2,
            'mask1_2'       => $this->mask1_2,
            'color1_2'      => $this->color1_2,
            'body1_2_1'     => $this->body1_2_1,
            'body1_2_2'     => $this->body1_2_2,

            'image1_3'      => ($this->image1_3) 
                                ? request()->root() .'/uploads/' . $this->image1_3->url : NULL,
            'line1_3'       => $this->line1_3,
            'mask1_3'       => $this->mask1_3,
            'color1_3'      => $this->color1_3,
            'body1_3_1'     => $this->body1_3_1,
            'body1_3_2'     => $this->body1_3_2,

            'image1_4'      => ($this->image1_4) 
                                ? request()->root() .'/uploads/' . $this->image1_4->url : NULL,
            'line1_4'       => $this->line1_4,
            'mask1_4'       => $this->mask1_4,
            'color1_4'      => $this->color1_4,
            'body1_4_1'     => $this->body1_4_1,
            'body1_4_2'     => $this->body1_4_2,

            'image1_5'      => ($this->image1_5) 
                                ? request()->root() .'/uploads/' . $this->image1_5->url : NULL,
            'line1_5'       => $this->line1_5,
            'mask1_5'       => $this->mask1_5,
            'color1_5'      => $this->color1_5,
            'body1_5_1'     => $this->body1_5_1,
            'body1_5_2'     => $this->body1_5_2,


            'image2_1'      => ($this->image2_1) 
                                ? request()->root() .'/uploads/' . $this->image2_1->url : NULL,
            'line2_1'       => $this->line2_1,
            'mask2_1'       => $this->mask2_1,
            'color2_1'      => $this->color2_1,
            'body2_1'       => $this->body2_1,

            'image2_2'      => ($this->image2_2) 
                                ? request()->root() .'/uploads/' . $this->image2_2->url : NULL,
            'line2_2'       => $this->line2_2,
            'mask2_2'       => $this->mask2_2,
            'color2_2'      => $this->color2_2,
            'body2_2'       => $this->body2_2,

            'image2_3'      => ($this->image2_3) 
                                ? request()->root() .'/uploads/' . $this->image2_3->url : NULL,
            'line2_3'       => $this->line2_3,
            'mask2_3'       => $this->mask2_3,
            'color2_3'      => $this->color2_3,
            'body2_3'       => $this->body2_3,

            'image2_4'      => ($this->image2_4) 
                                ? request()->root() .'/uploads/' . $this->image2_4->url : NULL,
            'line2_4'       => $this->line2_4,
            'mask2_4'       => $this->mask2_4,
            'color2_4'      => $this->color2_4,
            'body2_4'       => $this->body2_4,

            'image3_1'      => ($this->image3_1) 
                                ? request()->root() .'/uploads/' . $this->image3_1->url : NULL,
            'body3_1'       => $this->body3_1,

            'image3_2'      => ($this->image3_2) 
                                ? request()->root() .'/uploads/' . $this->image3_2->url : NULL,
            'body3_2'       => $this->body3_2,

            'image3_3'      => ($this->image3_3) 
                                ? request()->root() .'/uploads/' . $this->image3_3->url : NULL,
            'body3_3'       => $this->body3_3,

            'image3_4'      => ($this->image3_4) 
                                ? request()->root() .'/uploads/' . $this->image3_4->url : NULL,
            'body3_4'       => $this->body3_4,

            'image3_5'      => ($this->image3_5) 
                                ? request()->root() .'/uploads/' . $this->image3_5->url : NULL,
            'body3_5'       => $this->body3_5,

            'image3_6'      => ($this->image3_6) 
                                ? request()->root() .'/uploads/' . $this->image3_6->url : NULL,
            'body3_6'       => $this->body3_6,

            'image3_7'      => ($this->image3_7) 
                                ? request()->root() .'/uploads/' . $this->image3_7->url : NULL,
            'body3_7'       => $this->body3_7,

            'image3_8'      => ($this->image3_8) 
                                ? request()->root() .'/uploads/' . $this->image3_8->url : NULL,
            'body3_8'       => $this->body3_8,

            'image3_9'      => ($this->image3_9) 
                                ? request()->root() .'/uploads/' . $this->image3_9->url : NULL,
            'body3_9'       => $this->body3_9,




            'image4_1'      => ($this->image4_1) 
                                ? request()->root() .'/uploads/' . $this->image4_1->url : NULL,
            'body4_1'       => $this->body4_1,

            'image4_2'      => ($this->image4_2) 
                                ? request()->root() .'/uploads/' . $this->image4_2->url : NULL,
            'body4_2'       => $this->body4_2,

            'image4_3'      => ($this->image4_3) 
                                ? request()->root() .'/uploads/' . $this->image4_3->url : NULL,
            'body4_3'       => $this->body4_3,

            'image4_4'      => ($this->image4_4) 
                                ? request()->root() .'/uploads/' . $this->image4_4->url : NULL,
            'body4_4'       => $this->body4_4,



            'image1_5'      => ($this->image1_5) 
                                ? request()->root() .'/uploads/' . $this->image1_5->url : NULL,
            'line1_5'       => $this->line1_5,
            'mask1_5'       => $this->mask1_5,
            'color1_5'      => $this->color1_5,
            'body1_5_1'     => $this->body1_5_1,
            'body1_5_2'     => $this->body1_5_2,


            'image5_1'      => ($this->image5_1) 
                                ? request()->root() .'/uploads/' . $this->image5_1->url : NULL,
            'line5_1'       => $this->line5_1,
            'mask5_1'       => $this->mask5_1,
            'color5_1'      => $this->color5_1,
            'body5_1'       => $this->body5_1,

            'image5_2'      => ($this->image5_2) 
                                ? request()->root() .'/uploads/' . $this->image5_2->url : NULL,
            'line5_2'       => $this->line5_2,
            'mask5_2'       => $this->mask5_2,
            'color5_2'      => $this->color5_2,
            'body5_2'       => $this->body5_2,

            'image5_3'      => ($this->image5_3) 
                                ? request()->root() .'/uploads/' . $this->image5_3->url : NULL,
            'line5_3'       => $this->line5_3,
            'mask5_3'       => $this->mask5_3,
            'color5_3'      => $this->color5_3,
            'body5_3'       => $this->body5_3,

            'image5_4'      => ($this->image5_4) 
                                ? request()->root() .'/uploads/' . $this->image5_4->url : NULL,
            'line5_4'       => $this->line5_4,
            'mask5_4'       => $this->mask5_4,
            'color5_4'      => $this->color5_4,
            'body5_4'       => $this->body5_4,


            'image6_1'      => ($this->image6_1) 
                                ? request()->root() .'/uploads/' . $this->image6_1->url : NULL,
            'body6_1'       => $this->body6_1,

            'image6_2'      => ($this->image6_2) 
                                ? request()->root() .'/uploads/' . $this->image6_2->url : NULL,
            'body6_2'       => $this->body6_2,

            'image6_3'      => ($this->image6_3) 
                                ? request()->root() .'/uploads/' . $this->image6_3->url : NULL,
            'body6_3'       => $this->body6_3,

            'image6_4'      => ($this->image6_4) 
                                ? request()->root() .'/uploads/' . $this->image6_4->url : NULL,
            'body6_4'       => $this->body6_4,

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


            'has_download'     => (int)$this->has_download,
            'download_name'    => $this->download_name,
            'download_file'    => ($this->pdf) 
                                  ? request()->root() . '/uploads/' . $this->pdf->url : NULL,
            'download_image'   => ($this->image_pdf) 
                                  ? request()->root() . '/uploads/' . $this->image_pdf->url : NULL,

            'has_application'  => (int)$this->has_application,
            'application_name' => $this->application_name,
            'application_path' => $this->application_path,

            'has_faq'          => (int)$this->has_faq,
            'faq_link'         => $this->faq_link,

            'has_payment'      => (int)$this->has_payment,
            'payment_name'     => $this->payment_name,
            'payment_link'     => $this->payment_link,

            // Status & Visibility
            'has_footer'  => (int)$this->has_footer,
            'has_header'  => (int)$this->has_header,

            'sort'          => (int)$this->sort,
            'status'        => (int)$this->status,
            'trash'         => (int)$this->trash,
            'loading'       => false
        ];
    }
}
