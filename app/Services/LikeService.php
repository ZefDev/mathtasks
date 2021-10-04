<?php


namespace App\Services;


use App\Repositories\LikeRepository;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class LikeService
{
    protected $likeRepository;

    /**
     * @return mixed
     */
    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
    }

    public function setLike($data){
        $validator = Validator::make($data,[
            'comment_id'=>'required',
            'user_id'=>'required',
            'type_like'=>'required'
        ]);
        if ($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $like = $this->likeRepository->getLike($data);

        if ($like && $like->type_like == $data['type_like']){
            $this->likeRepository->delete($like->id);
        }
        else{
            $like = $this->likeRepository->save($data);
        }

        return $like;
    }

}

