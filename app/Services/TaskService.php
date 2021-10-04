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

    public function getLastTasks($limit){
        return $this->taskRepository->getLastTasks($limit);
    }

    public function getTopTasks($limit){
        return $this->taskRepository->getTopTasks($limit);
    }

    public function saveTask($data){
        $validator = Validator::make($data,[
            'theme_id'=>'required',
            'name'=>'required',
            'condition'=>'required',
            'user_id'=>'required'
        ]);
        if ($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }
        return $this->taskRepository->save($data);
    }

    public function updateTask($data, $id){
        $validator = Validator::make($data,[
            'theme_id'=>'required',
            'name'=>'required',
            'condition'=>'required',
            'user_id'=>'required'
        ]);
        if ($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }
        return $this->taskRepository->update($data,$id);
    }

    public function deleteTask($id){
        return $this->taskRepository->delete($id);
    }
}

