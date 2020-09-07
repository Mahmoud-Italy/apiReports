<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class MyCertificateResource extends JsonResource
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
            'id'         => $this->id,
            'preview'    => NULL,
            'pdf'        => NULL,
            'title'      => $this->title,
            'subTitle'   => $this->subTitle,
        ];
    }
}
