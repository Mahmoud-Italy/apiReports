<?php

namespace App\Http\Resources\Backend;

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

            'passport_file'      => ($this->file1) ? request()->root() .'/uploads/' . $this->file1->url : NULL,
            'passport_size_file' => ($this->file2) ? request()->root() .'/uploads/' . $this->file2->url : NULL,
            'occupation_file'    => ($this->file3) ? request()->root() .'/uploads/' . $this->file3->url : NULL,
            'detailed_resume'    => ($this->file4) ? request()->root() .'/uploads/' . $this->file4->url : NULL,
            'hr_letter_file'     => ($this->file5) ? request()->root() .'/uploads/' . $this->file5->url : NULL,

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
            'status'        => (int)$this->status,
            'trash'         => (int)$this->trash,
            'loading'       => false
        ];
    }
}
