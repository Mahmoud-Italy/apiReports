<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;

class SectorResource extends JsonResource
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
            'encrypt_id'    => encrypt($this->id),
            
            'download_file'  => ($this->pdf) ? request()->root() .'/uploads/' . $this->pdf->url : NULL,
            'download_image' => ($this->pdf_image) ? request()->root() .'/uploads/' . $this->pdf_image->url : NULL,
            'download_name'  => $this->download_name,

            'childs'        => count($this->childs),

            'parent'        => ($this->parent) ? $this->parent->title : 'No Parent',

            'program_id'    => $this->program_id,
            'parent_id'     => $this->parent_id,
            'slug'          => $this->slug,
            'title'         => $this->title,
            'body'          => $this->body,
            'bgTitle'       => $this->bgTitle,
            'bgColor'       => $this->bgColor,

            // total packages
            'programs'      => $this->programs->count(),
            //'sub'           => $this->sub->count(),

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
            'sort'          => (int)$this->sort,
            'status'        => (boolean)$this->status,
            'trash'         => (boolean)$this->trash,
            'loading'       => false
        ];
    }
}
