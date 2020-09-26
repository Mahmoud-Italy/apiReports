<?php

namespace App\Http\Resources\Backend;

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

            'wbody1' => $this->wbody1,
            'wbody2' => $this->wbody2,
            'wbody3' => $this->wbody3,
            'wbody4' => $this->wbody4,

            'mabody1' => $this->mabody1,
            'mabody2' => $this->mabody2,
            'mabody3' => $this->mabody3,
            'mabody4' => $this->mabody4,

            'iabody1' => $this->iabody1,
            'iabody2' => $this->iabody2,
            'iabody3' => $this->iabody3,
            'iabody4' => $this->iabody4,

            'pabody1' => $this->pabody1,
            'pabody2' => $this->pabody2,
            'pabody3' => $this->pabody3,
            'pabody4' => $this->pabody4,

            'habody1' => $this->habody1,
            'habody2' => $this->habody2,
            'habody3' => $this->habody3,
            'habody4' => $this->habody4,

            'cabody1' => $this->cabody1,
            'cabody2' => $this->cabody2,
            'cabody3' => $this->cabody3,
            'cabody4' => $this->cabody4,

            'aabody1' => $this->aabody1,
            'aabody2' => $this->aabody2,
            'aabody3' => $this->aabody3,
            'aabody4' => $this->aabody4,


        ];
    }
}
