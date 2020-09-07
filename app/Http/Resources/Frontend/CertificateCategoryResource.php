<?php

namespace App\Http\Resources\Frontend;

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
            'title'   => $this->title,
            'image'   => $this->image() ? request()->root(). '/uploads/' . $this->image()->url : null,
            'pdf'     => $this->pdf() ? request()->root(). '/uploads/' . $this->pdf()->url : null,
        ];
    }
}
