<?php

namespace App\Http\Resources\Backend;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            
            'name'          => $this->name,
            'url'           => strtolower(str_replace(' ','-',$this->name)),
            'icon'          => $this->icon,

            'dateForHumans' => $this->created_at->diffForHumans(),
            'timestamp'     => $this->created_at,

            'setup'         => (boolean)$this->setup,
            'status'        => (boolean)$this->status,
            'trash'         => (boolean)$this->trash
        ];
    }
}
