<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SprintWithGoalsResource extends JsonResource
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
            'sprint_nr' => $this->sprint_nr,
            'reflection' => $this->reflection,
            'feedback' => $this->feedback,
            'status' => new SprintStatusResource($this->status),
            'created_at' => $this->created_at,
            'goals' => GoalsResource::collection($this->goals),
        ];
    }
}
