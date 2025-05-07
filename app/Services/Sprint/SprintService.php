<?php

namespace App\Services\Sprint;

use App\Models\Sprint;

class SprintService
{
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