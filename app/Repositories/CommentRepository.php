<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function save($data){
        $comment = new $this->comment;
        $comment->task_id = (int) $data['task_id'];
        $comment->text = $data['text'];
        $comment->user_id = $data['user_id'];
        $comment->save();
        return $comment;
    }

    public function getComments($idTask){
        return $this->comment->with('user','likes','dislike','like')->where([
            ['task_id','=',$idTask],
        ])->get();
    }
}
