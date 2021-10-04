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

    public function getAll(){
        return $this->taskRepository->getAllTasks();
    }
    public function getAllCurentUser($id){
        return $this->taskRepository->getAllTasksByUserId($id);
    }
    public function getCountCreatedTasks($id){
        return $this->taskRepository->getCountCreatedTasksByUserId($id);
    }

    public function getTaskById($id){
        return $this->taskRepository->getTaskById($id);
    }
}

