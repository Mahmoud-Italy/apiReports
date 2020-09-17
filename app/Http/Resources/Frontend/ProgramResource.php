<?php

namespace App\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Frontend\SectorResource;

class ProgramResource extends JsonResource
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
            'id'             => $this->id,
            'image'         => ($this->image) ? request()->root() .'/uploads/' . $this->image->url : NULL,
            'download_file' => ($this->pdf) 
                                ? request()->root() . '/uploads/' . $this->pdf->url : NULL,
            'download_image' => ($this->image_pdf) 
                                ? request()->root() . '/uploads/' . $this->image_pdf->url : NULL,
                                
            'download_name'  => $this->download_name,

            'bgTitle'       => $this->bgTitle,
            'bgColor'       => $this->bgColor,
            'slug'          => $this->slug,
            'title'         => $this->title,
            'body'          => $this->body,

            'has_application'  => (int)$this->has_application,
            'application_name' => $this->application_name,
            'application_path' => $this->application_path,
            
            'has_sectors'   => (boolean)$this->has_sectors,
            'sectors'       => SectorResource::collection($this->sectors),
        ];
    }
}
