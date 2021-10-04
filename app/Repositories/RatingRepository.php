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
}
