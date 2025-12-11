<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'label'     => $this->label,
            'url'       => $this->url,
            'page_id'   => $this->page_id,
            'parent_id' => $this->parent_id,
            'order'     => $this->order,
            'location'  => $this->location,
            'is_active' => $this->is_active,

            // Relationships
            'page'     => $this->whenLoaded('page'),
            'parent'   => $this->whenLoaded('parent'),
            'children' => MenuResource::collection($this->whenLoaded('children')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}