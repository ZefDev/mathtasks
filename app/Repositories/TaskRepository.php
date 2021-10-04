<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskRepository{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getAllTasks(){
        return $this->task->select()->with('user','theme')
            ->withAvg('raitings', 'mark')
            ->withCount('raitings')
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function getAllTasksByUserId($id){
        return $this->task->select()->where([
            ['user_id', '=', $id]
        ])->withAvg('raitings','mark')
            ->withCount('raitings')
            ->orderBy('id', 'DESC')->get();
    }

    public function getCountCreatedTasksByUserId($id){
        return $this->task->select()->where([
            ['user_id', '=', $id]
        ])->count();
    }

    public function getTaskById($id){
        return $this->task->with('user','theme','answers','images','raitings')->find($id);
    }
}
