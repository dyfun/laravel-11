<?php

namespace App\Http\Controllers;

use App\Services\TaskService\TaskService;
use Illuminate\Contracts\View\View;

class TaskController extends Controller
{
    /**
     * TaskController constructor.
     */
    public function __construct(private readonly TaskService $taskService) {}

    /**
     * Assign task to user
     */
    public function taskAssignReport(): View
    {
        $data = $this->taskService->assign();

        return view('task', compact('data'));
    }
}
