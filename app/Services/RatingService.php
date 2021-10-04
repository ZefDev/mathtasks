<?php


namespace App\Services;

use App\Repositories\RatingRepository;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class RatingService
{
    protected $ratingRepository;

    /**
     * @return mixed
     */
    public function __construct(RatingRepository $ratingRepository)
    {
        $this->ratingRepository = $ratingRepository;
    }

    public function getRatingCurentTask($idTask,$idUser){
       return $this->ratingRepository->getRatingCurentTaskByUserId($idTask,$idUser);
    }

    public function saveRating($data){
        $validator = Validator::make($data,[
            'task_id'=>'required',
            'user_id'=>'required',
            'mark'=>'required'
        ]);
        if ($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }
        return $this->ratingRepository->save($data);
    }

}

