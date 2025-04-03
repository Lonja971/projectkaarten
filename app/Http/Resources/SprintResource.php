<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SprintResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'week_nr' => $this->week_nr,
            'reflection' => $this->reflection,
            'feedback' => $this->feedback,
            'status' => new SprintStatusResource($this->status),
            'created_at' => $this->created_at,
        ];
    }
}
