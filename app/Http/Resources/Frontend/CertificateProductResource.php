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

            'download_pdf'   => $this->pdf ? request()->root(). '/uploads/' . $this->pdf->url : null,
            'download_image' => $this->image_pdf ? request()->root(). '/uploads/' . $this->image_pdf->url : null,
            'download_name'  => $this->download_name,

            'title'     => $this->title,
            'subTitle'  => $this->subtitle,
            'slug'      => $this->slug,
            'shortBody' => $this->short_body
        ];
    }
}
