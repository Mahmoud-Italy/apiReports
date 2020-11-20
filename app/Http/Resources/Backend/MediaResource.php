<?php

namespace App\Http\Resources\Backend;

use App\Models\Tenant;
use App\Http\Resources\Backend\TinyUserResource;
use App\Http\Resources\Backend\ImageableResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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

            'tenant_id'      => $this->tenant_id,
            'tenant_name'    => Tenant::getTenantName($this->tenant_id),
            
            'image'         => ($this->image) ? (new ImageableResource($this->image))->foo('medias') : NULL,
            'user'          => ($this->user) ? new TinyUserResource($this->user) : NULL,
            'mime_type'     => $this->mime_type,
            'size'          => $this->size,

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
