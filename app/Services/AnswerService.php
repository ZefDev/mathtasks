<?php


namespace App\Services;

use App\Models\Answer;
use App\Repositories\AnswerRepository;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class AnswerService
{
    protected $answerRepository;

    /**
     * @return mixed
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function saveAnswer($data,$task_id){
        foreach ($data as $item) {
            $this->answerRepository->save($item,$task_id);
        }
        return true;
    }

    public function updateAnswer($data,$task_id){
        foreach ($data as $item) {
            if (isset($item->id)){
                $this->answerRepository->update($item,$item->id);
            }else{
                $this->answerRepository->save($item,$task_id);
            }
        }
        return true;
    }

    public function deleteAnswer($id){
        $this->answerRepository->delete($id);
    }

}

