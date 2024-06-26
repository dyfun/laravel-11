<?php

namespace App\Services\TaskAssignService;

use App\Models\Developer;
use App\Models\Provider;
use App\Models\Task;

class TaskService
{
    protected int $weeklyHours = 45;

    protected string $namespace = 'App\Services\TaskAssignService\Providers\\';

    private TaskAbstract $provider;

    /**
     * @throws \Exception
     */
    public function setProvider(Provider $provider): void
    {
        $providerName = ucwords(strtolower($provider->class_name));
        $class = $this->namespace.$providerName;
        if (! class_exists($class)) {
            $errorMessages = 'Provider not found';
        }

        if (! empty($errorMessages)) {
            throw new \Exception($errorMessages, 404);
        }

        $this->provider = $class::getInstance();
    }

    public function fetch(): void
    {
        $this->provider->fetch();
    }

    public function assign(): array
    {
        // Define initial data
        $tasks = Task::orderByRaw('value * estimated_duration DESC')->get();
        $developers = Developer::orderByRaw('difficulty')->get();
        $assignedTasksIds = [];
        $assignedTasks = [];

        // Calculate all task efforts
        $allTaskEfforts = 0;
        $tasks->each(function ($task) use (&$allTaskEfforts) {
            $allTaskEfforts += $task->value * $task->estimated_duration;
        });

        // Calculate all developer efforts
        $allDeveloperEfforts = 0;
        $developers->each(function ($developer) use (&$allDeveloperEfforts) {
            $allDeveloperEfforts += $developer->difficulty * $developer->hours;
        });

        // Calculate single developer effort
        $singleDeveloperEffort = $allTaskEfforts / $allDeveloperEfforts;
        if ($singleDeveloperEffort >= $this->weeklyHours) {
            $singleDeveloperEffort = $this->weeklyHours;
        }

        foreach ($developers as $key => $developer) {
            // Create array for all developer
            $assignedTasks[$key] = [
                'developer' => [
                    'name' => $developer->name,
                    'difficulty' => $developer->difficulty,
                    'hours' => $developer->hours,
                ],
                'remaining_capacity' => $singleDeveloperEffort,
                'total_time' => 0,
                'tasks' => [],
            ];

            foreach ($tasks as $task) {
                // Check if task is already assigned
                if (in_array($task->id, $assignedTasksIds)) {
                    continue;
                }

                $workDuration = ($task->value * $task->estimated_duration) / $developer->difficulty;
                if ($assignedTasks[$key]['remaining_capacity'] >= 0 && $assignedTasks[$key]['remaining_capacity'] - $workDuration >= 0) {
                    $assignedTasks[$key]['remaining_capacity'] = (int) $assignedTasks[$key]['remaining_capacity'] - (int) $workDuration;
                    $assignedTasks[$key]['total_time'] = (int) $assignedTasks[$key]['total_time'] + (int) $workDuration;
                    $assignedTasks[$key]['tasks'][] = $task->id;

                    $assignedTasksIds[] = $task->id;
                }
            }
        }

        return [
            'all_tasks' => count($tasks),
            'tasks' => $assignedTasks,
            'min_week' => round(($allTaskEfforts / $allDeveloperEfforts) / $this->weeklyHours, 1),
        ];
    }
}
