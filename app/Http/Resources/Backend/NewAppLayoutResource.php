<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;

class NewAppLayoutResource extends JsonResource
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
            'image'         => ($this->image) ? request()->root() .'/uploads/' . $this->image->url : NULL,

            'bgColor'       => $this->bgColor,
            'bgTitle'       => $this->bgTitle,
            'bgSubTitle'    => $this->bgSubTitle,

            'text1'         => $this->text1,
            'text2'         => $this->text2,
            'text3'         => $this->text3,

            'pdf1'          => $this->pdf1,
            'pdf2'          => $this->pdf2,
            'pdf3'          => $this->pdf3,
            'pdf4'          => $this->pdf4,
            'pdf5'          => $this->pdf5,
            'pdf6'          => $this->pdf6,

            'text4'         => $this->text4,

            // Step 2
            'general1_title' => $this->general1_title,
            'general1_body'  => $this->general1_body,
            'general2_title' => $this->general2_title,
            'general2_body'  => $this->general2_body,
            'general3_title' => $this->general3_title,
            'general3_body'  => $this->general3_body,
            'general4_title' => $this->general4_title,
            'general4_body'  => $this->general4_body,
            'general5_title' => $this->general5_title,
            'general5_body'  => $this->general5_body,

            'note1'          => $this->note1,
            'note2'          => $this->note2,

            'text5'         => $this->text5,

            // Step 3
            'authority_note'  => $this->authority_note,
            'authority_title' => $this->authority_title,

            'authority1'    => $this->authority1,
            'authority2'    => $this->authority2,
            'authority3'    => $this->authority3,
            'authority4'    => $this->authority4,
            'authority5'    => $this->authority5,
            'authority6'    => $this->authority6,

            'head'          => $this->head,
            'last_confirm'  => $this->last_confirm,
        ];
    }
}
