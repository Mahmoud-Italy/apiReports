<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;

class CertProductResource extends JsonResource
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

            'slug'          => $this->slug,
            'title'         => $this->title,
            'subtitle'      => $this->subtitle,
            'body'          => $this->body,
            'short_body'    => $this->short_body,
            
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
            'sort'          => (int)$this->sort,
            'status'        => (int)$this->status,
            'trash'         => (int)$this->trash,
            'loading'       => false
        ];
    }
}
