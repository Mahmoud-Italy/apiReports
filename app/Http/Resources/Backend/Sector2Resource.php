<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;

class Sector2Resource extends JsonResource
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
            'image'         => ($this->image) ? request()->root() .'/uploads/' . $this->image->url : NULL,

            'download_file'  => ($this->pdf) ? request()->root() .'/uploads/' . $this->pdf->url : NULL,
            'download_image' => ($this->pdf_image) ? request()->root() .'/uploads/' . $this->pdf_image->url : NULL,
            'download_name'  => $this->download_name,


            'slug'          => $this->slug,
            'title'         => $this->title,
            'subTitle'         => $this->subTitle,

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
            'status'        => (int)$this->status,
            'trash'         => (int)$this->trash,
            'loading'       => false
        ];
    }
}
