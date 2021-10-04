<?php

namespace App\Repositories;

use App\Models\Like;

class LikeRepository{
    protected $like;

    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function save($data){
        return $this->like->updateOrCreate([
            ['comment_id','=',$data['comment_id']],
            ['user_id', '=', $data['user_id']]
        ],[
            'comment_id'     => $data['comment_id'],
            'user_id' => $data['user_id'],
            'type_like'    => $data['type_like'],
        ]);
    }

    public function getLike($data){
        return $this->like->select()->where([
            ['comment_id','=',$data['comment_id']],
            ['user_id', '=', $data['user_id']]
        ])->first();
    }

    public function delete($id){
        return $this->like->destroy($id);
    }
}
