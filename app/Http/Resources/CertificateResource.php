<?php

namespace App\Http\Resources;

use App\Models\CertificateCategory;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResource extends JsonResource
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
            'image'         => ($this->image) ? request()->root() . $this->image->url : NULL,
            'pdf'           => ($this->image_pdf) ? request()->root() . $this->image_pdf->url : NULL,
            
            
            'bgTitle1'      => $this->bgTitle1,
            'bgSubTitle1'   => $this->bgSubTitle1,
            'bgColor1'      => $this->bgColor1,
            'body1'         => $this->body1,
            'bgTitle2'      => $this->bgTitle2,
            'bgSubTitle2'   => $this->bgSubTitle2,
            'bgColor2'      => $this->bgColor2,
            'body2'         => $this->body2,

            'hint2'         => $this->hint2,
            'duration'      => $this->duration,
            'dTitle'        => $this->dTitle,
            'cTitle'        => $this->cTitle,
            'cBody'         => $this->cBody,

            'cat1'          => [],
            'cat2'          => [],
            'cat3'          => [],

            // Dates
            'dateForHumans' => $this->created_at->diffForHumans(),
            'timestamp'     => $this->created_at,


            // Status & Visibility
            'download_name' => $this->download_name,
            'has_download'  => (boolean)$this->has_download,

            'status'        => (boolean)$this->status,
            'trash'         => (boolean)$this->trash,
            'loading'       => false
        ];
    }
}
