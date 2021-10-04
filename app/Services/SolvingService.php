<?php


namespace App\Services;

use App\Models\Task;
use App\Repositories\SolvingRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class SolvingService
{
    protected $solvingRepository;

    /**
     * @return mixed
     */
    public function __construct(SolvingRepository $solvingRepository)
    {
        $this->solvingRepository = $solvingRepository;
    }

    public function getCountSolvedTasks($id){
        return $this->solvingRepository->getCountSolvedTasksByUserId($id);
    }

    public function getSolvingTask($taskId,$userId){
        return $this->solvingRepository->getSolvingTask($taskId,$userId);
    }

    public function saveSolving($data){
        $validator = Validator::make($data,[
            'answer'=>'required',
            'task_id'=>'required',
            'user_id'=>'required'
        ]);
        if ($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }
        $data['is_task_solved'] = $this->checkAnswer($data['task_id'],$data['answer']);

        return $this->solvingRepository->save($data);
    }
    public function checkAnswer($task_id,$answerUser){
        $answers = Task::find($task_id)->answers()->where([['answer','=',$answerUser]])->count();
        if (!empty($answers)){
            return true;
        }
        return false;
    }
}

