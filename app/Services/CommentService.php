<?php


namespace App\Services;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class CommentService
{
    protected $commentRepository;

    /**
     * @return mixed
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function saveComment($data){
        $validator = Validator::make($data,[
            'task_id'=>'required',
            'text'=>'required',
            'user_id'=>'required'
        ]);
        if ($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }
        return $this->commentRepository->save($data);
    }

    public function getComments($idTask){
        return $this->commentRepository->getComments($idTask);
    }
}

