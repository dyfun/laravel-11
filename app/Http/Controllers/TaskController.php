<?php

namespace App\Http\Controllers;

use App\Services\TaskAssignService\TaskService;
use Illuminate\Contracts\View\View;

class TaskController extends Controller
{
    /**
     * TaskController constructor.
     *
     * @param TaskService $taskService
     */
    public function __construct(private readonly TaskService $taskService) {}

    /**
     * Assign task to user
     *
     * @return View
     */
    public function assignTask(): View
    {
        $data = $this->taskService->assign();

        return view('task', compact('data'));
    }
}
