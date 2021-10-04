<?php

namespace App\Http\Controllers;

use App\Models\Solving;
use App\Models\Task;
use App\Services\SolvingService;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolvingController extends Controller
{
    protected $taskService;
    protected $solvingService;
    /**
     * @return mixed
     */
    public function __construct(TaskService $taskService,
                                SolvingService $solvingService)
    {
        $this->taskService = $taskService;
        $this->solvingService = $solvingService;
    }

    public function create(Request $request){
        $data = $request->only([
            'answer',
            'task_id',
        ]);
        $data['user_id'] = Auth::id();

        return $this->solvingService->saveSolving($data);
    }

}
