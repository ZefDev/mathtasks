<?php

namespace App\Repositories;

use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class AnswerRepository{
    protected $answer;

    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    public function save($data,$task_id){
        $answer = new $this->answer;
        $answer->answer = isset($data->answer) ? $data->answer: $data->name;
        $answer->task_id = $task_id;
        $answer->save();
        return $answer;
    }
    public function update($data,$id){
        $answer = $this->answer->find($id);
        $answer->answer = $data->answer;
        $answer->save();
        return $answer;
    }

    public function delete($id){
        return $this->answer->find($id)->delete();
    }
}
