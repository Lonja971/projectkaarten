<?php

namespace App\Services\Sprint;

use App\Models\Sprint;
use App\Models\Project;
use App\Models\User;

class SprintService
{
    public function userCanUpdate(int $userId, Sprint $sprint): bool
    {
        if (User::isTeacher($userId)) {
            return true;
        }

        return Project::getUserIdByProjectId($sprint->project_id) === $userId;
    }

    public function updateSprintInfo(Sprint $sprint, array $data): bool
    {
        foreach ($data as $key => $value) {
            if ($sprint->$key !== $value) {
                $sprint->update($data);
                return true;
            }
        }

        return false;
    }
}