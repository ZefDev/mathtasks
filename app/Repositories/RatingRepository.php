<?php

namespace App\Repositories;

use App\Models\Raiting;
use Illuminate\Support\Facades\Auth;

class RatingRepository{
    protected $rating;

    public function __construct(Raiting $rating)
    {
        $this->rating = $rating;
    }

    public function getRatingCurentTaskByUserId($idTask,$idUser){
        return $this->rating->select()->where([
            ['task_id','=',$idTask],
            ['user_id','=',$idUser],
        ])->first();
    }

    public function save($data){
        return $this->rating->updateOrCreate([
            ['task_id','=',$data['task_id']],
            ['user_id', '=', $data['user_id']]
        ],[
            'task_id'     => $data['task_id'],
            'user_id' => $data['user_id'],
            'mark'    => $data['mark'],
        ]);
    }
}
