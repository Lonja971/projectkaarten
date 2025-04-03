<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'user_id' => $this->user_id,
            'title' => $this->title,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'date_end' => $this->date_end,
            'reflection' => $this->reflection,
            'raiting' => $this->raiting,
            'feedback' => $this->feedback,
            'denial_reason' => $this->denial_reason,
            'status' => new ProjectStatusResource($this->status),
            'icon_id' => $this->icon_id,
            'background_id' => $this->background_id,
            'project_by_student' => $this->project_by_student,
            'created_at' => $this->created_at,
            'sprints' => SprintResource::collection($this->sprints),
        ];
    }
}
