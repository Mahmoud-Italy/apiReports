<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DestinationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // test GRAPH API idea
        // $id = true;
        // $res  = ($id) ? ['id' => $this->id] : []; 
        // $res1 = ['encrypt_id' => encrypt($this->id)];
        // $res2 = ['slug'  => $this->slug];
        // $res3 = ['title' => $this->title];
        // $res4 = ['body'  => $this->body];
        // $merge = array_merge($res, $res1, $res2, $res3, $res4);
        // return $merge;
        return [
            'id'            => $this->id,
            'encrypt_id'    => encrypt($this->id),
            
            'image'         => ($this->image) ?? NULL,
            'meta'          => ($this->meta) ?? NULL,
            'user'          => ($this->user) ?? NULL,
            'region'        => ($this->region) ?? NULL,

            'slug'          => $this->slug,
            'title'         => $this->title,
            'body'          => $this->body,

            // total packages
            'packages'      => $this->packages->count(),

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
