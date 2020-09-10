<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmailTemplateResource extends JsonResource
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
            'fbody1' => $this->fbody1,
            'fbody2' => $this->fbody2,
            'fbody3' => $this->fbody3,
            'fbody4' => $this->fbody4,

            'rbody1' => $this->rbody1,
            'rbody2' => $this->rbody2,
            'rbody3' => $this->rbody3,
            'rbody4' => $this->rbody4,

            'vbody1' => $this->vbody1,
            'vbody2' => $this->vbody2,
            'vbody3' => $this->vbody3,
            'vbody4' => $this->vbody4,

            'wfbody1' => $this->wbody1,
            'wfbody2' => $this->wbody2,
            'wfbody3' => $this->wbody3,
            'wfbody4' => $this->wbody4,
        ];
    }
}
