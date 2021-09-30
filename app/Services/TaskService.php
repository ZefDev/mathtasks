<?php

namespace App\Services;
use App\Repositories\TaskRepository;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class TaskService{
    protected $taskRepository;

    /**
     * @return mixed
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
}

