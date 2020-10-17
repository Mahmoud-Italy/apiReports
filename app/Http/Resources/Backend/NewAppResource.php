<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;

class NewAppResource extends JsonResource
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
            'logo'               => ($this->logo) ? request()->root() .'/uploads/' . $this->logo->url : NULL,

            'file1'              => ($this->file1) ? request()->root() .'/uploads/' . $this->file1->url : NULL,
            'file2'              => ($this->file2) ? request()->root() .'/uploads/' . $this->file2->url : NULL,
            'file3'              => ($this->file3) ? request()->root() .'/uploads/' . $this->file3->url : NULL,
            'file4'              => ($this->file4) ? request()->root() .'/uploads/' . $this->file4->url : NULL,
            'file5'              => ($this->file5) ? request()->root() .'/uploads/' . $this->file5->url : NULL,
            'file6'              => ($this->file6) ? request()->root() .'/uploads/' . $this->file6->url : NULL,
            'file7'              => ($this->file7) ? request()->root() .'/uploads/' . $this->file7->url : NULL,


            'name_of_institution' => $this->name_of_institution,
            'address'             => $this->address,
            'country'             => $this->country,
            'state'               => $this->state,
            'type'                => $this->type,
            'establishment_date'  => $this->establishment_date,
            'commerical_register_no' => $this->commerical_register_no,
            'telephone_no'        => $this->telephone_no,
            'email_address'       => $this->email_address,
            'website_url'         => $this->website_url,

            'nationality'         => $this->country,
            'program'             => '-',

            //
            'general1'           => (int)$this->general1,
            'general2'           => (int)$this->general2,
            'general3'           => (int)$this->general3,
            'general4'           => (int)$this->general4,
            'general5'           => (int)$this->general5,

            'authority1'         => (int)$this->authority1,
            'authority2'         => (int)$this->authority2,
            'authority3'         => (int)$this->authority3,
            'authority4'         => (int)$this->authority4,
            'authority5'         => (int)$this->authority5,
            'authority6'         => (int)$this->authority6,

            'name'                => $this->name,
            'date'                => $this->date,
            

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
