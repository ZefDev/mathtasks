<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\TaskService;

class DashboardController extends Controller
{
    protected $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    public function index(){

        $lastTask = $this->taskService->getLastTasks(4);
        $topTask = $this->taskService->getTopTasks(4);

        return Inertia::render('Dashboard', [
            'lastTask' => $lastTask,
             'topTask' => $topTask
        ]);
    }

    public function indexBlock(){
        return Inertia::render('Block');
    }
}
