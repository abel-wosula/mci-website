<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'filename'      => $this->filename,
            'original_name' => $this->original_name,
            'path'          => $this->path,
            'url'           => $this->url, // accessor for full URL
            'mime_type'     => $this->mime_type,
            'size'          => $this->size,
            'type'          => $this->type,
            'user_id'       => $this->user_id,
            'mediable_id'   => $this->mediable_id,
            'mediable_type' => $this->mediable_type,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ];
    }
}
