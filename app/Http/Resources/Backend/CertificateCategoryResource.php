<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;

class CertificateCategoryResource extends JsonResource
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
            'image'    => ($this->image) ? request()->root() .'/uploads/' . $this->image->url : NULL,
            'pdf'      => ($this->pdf) ? request()->root() .'/uploads/' . $this->pdf->url : NULL,
            'title'    => $this->title,
        ];
    }
}
