<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class CertificateProductResource extends JsonResource
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
            'id'        => $this->id,
            'image'     => $this->image ? request()->root(). '/uploads/' . $this->image->url : null,

            'has_download'   => (int)$this->has_download,
            'download_file'  => ($this->pdf) 
                                ? request()->root() . '/uploads/' . $this->pdf->url : NULL,
            'download_image' => ($this->image_pdf) 
                                ? request()->root() . '/uploads/' . $this->image_pdf->url : NULL,
            'download_name'  => $this->download_name,


            'has_application'  => (int)$this->has_application,
            'application_name' => $this->application_name,
            'application_path' => $this->application_path,

            
            'has_faq'          => (int)$this->has_faq,
            'faq_link'         => $this->faq_link,

            'has_payment'      => (int)$this->has_payment,
            'payment_name'     => $this->payment_name,
            'payment_link'     => $this->payment_link,

            'title'     => $this->title,
            'subTitle'  => $this->subtitle,
            'slug'      => $this->slug,
            'shortBody' => $this->short_body
        ];
    }
}
