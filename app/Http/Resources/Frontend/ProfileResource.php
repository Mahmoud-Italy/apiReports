<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'avatar'     => ($this->image) ? request()->root() . '/uploads/' . $this->image->url : NULL,
            'email'      => $this->email,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'country'    => $this->country,
            'ccode'      => $this->ccode,
            'mobile'     => $this->mobile,
            'website'    => $this->website,
        ];
    }
}
