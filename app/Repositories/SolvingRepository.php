<?php

namespace App\Repositories;

use App\Models\Solving;
use Illuminate\Support\Facades\Auth;

class SolvingRepository{
    protected $solving;

    public function __construct(Solving $solving)
    {
        $this->solving = $solving;
    }

    public function getCountSolvedTasksByUserId($id){
        return Solving::select()->where([
            ['user_id', '=', $id],
            ['is_task_solved', '=', 1],
        ])->count();
    }

    public function getSolvingTask($taskId,$userId){
        return Solving::select()->where([
            ['is_task_solved','=',1],
            ['task_id','=',$taskId],
            ['user_id','=',$userId],
        ])->count();
    }

    public function save($data){
        $solving = new $this->solving;
        $solving->user_id = $data['user_id'];
        $solving->answerUser = $data['answer'];
        $solving->task_id = $data['task_id'];
        $solving->is_task_solved = $data['is_task_solved'];
        $solving->save();
        return $solving;
    }
}
