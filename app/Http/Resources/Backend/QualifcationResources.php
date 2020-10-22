<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;

class QualifcationsResource extends JsonResource
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
            'educational'   => $this->educational,
            'univeristy'    => $this->univeristy,
            'grade'         => $this->grade,
            'year'          => $this->year,
            'date_from'     => $this->date_from,
            'date_to'       => $this->date_to,
            'certificate'   => request()->root() . '/uploads/' . $this->certificate,
        ];
    }
}
