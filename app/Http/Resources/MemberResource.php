<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'id'                 => $this->id,
            'encrypt_id'         => encrypt($this->id),
            'image'              => ($this->image) ? request()->root() .'/uploads/' . $this->image->url : NULL,

            'passport_file'      => ($this->pdf1) ? request()->root() .'/uploads/' . $this->pdf1->url : NULL,
            'passport_size_file' => ($this->pdf2) ? request()->root() .'/uploads/' . $this->pdf2->url : NULL,
            'occupation_file'    => ($this->pdf3) ? request()->root() .'/uploads/' . $this->pdf3->url : NULL,
            'detailed_resume'    => ($this->pdf4) ? request()->root() .'/uploads/' . $this->pdf4->url : NULL,
            'hr_letter_file'     => ($this->pdf5) ? request()->root() .'/uploads/' . $this->pdf5->url : NULL,

            'name'               => $this->first_name. ' '.$this->last_name,
            'first_name'         => $this->first_name,
            'middle_name'        => $this->middle_name,
            'last_name'          => $this->last_name,
            'full_name'          => $this->full_name,
            'nationality'        => $this->nationality,
            'residential_address'=> $this->residential_address,
            'telephone_no'       => $this->telephone_no,
            'email_Address'      => $this->email_Address,
            'video_url'          => $this->video_url,

            'courses'            => $this->courses,
            'languages'          => $this->languages,
            'qualifications'      => $this->qualifcations,

            // Dates
            'dateForHumans' => $this->created_at->diffForHumans(),
            'created_at'    => ($this->created_at == $this->updated_at) 
                                ? 'Created <br/>'. $this->created_at->diffForHumans()
                                : NULL,
            'updated_at'    => ($this->created_at != $this->updated_at) 
                                ? 'Updated <br/>'. $this->updated_at->diffForHumans()
                                : NULL,
            'deleted_at'    => ($this->updated_at && $this->trash) 
                                ? 'Deleted <br/>'. $this->updated_at->diffForHumans()
                                : NULL,
            'timestamp'     => $this->created_at,


            // Status & Visibility
            'status'        => (boolean)$this->status,
            'trash'         => (boolean)$this->trash,
            'loading'       => false
        ];
    }
}
