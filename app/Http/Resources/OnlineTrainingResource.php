<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OnlineTrainingResource extends JsonResource
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

            'slug'          => $this->slug,
            'title'         => $this->title,
            'body'          => $this->body,

            'bgTitle'       => $this->bgTitle,
            'bgColor'       => $this->bgColor,

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
            //'download_name' => $this->download_name,
            'sort'          => (int)$this->sort,
            'has_faq'       => (int)$this->has_faq,
            'has_scroll'    => (int)$this->has_scroll,
            //'has_training'  => (int)$this->has_training,
            //'has_download'  => (int)$this->has_download,
            
            'status'        => (boolean)$this->status,
            'trash'         => (boolean)$this->trash,
            'loading'       => false
        ];
    }
}
