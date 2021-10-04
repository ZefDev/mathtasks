<?php

namespace App\Http\Controllers;

use App\Services\LikeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService){
        $this->likeService = $likeService;
    }

    public function like(Request $request){
        $data = $request->only([
            'comment_id',
            'type_like'
        ]);
        $data['user_id'] = Auth::id();

        return $this->likeService->setLike($data);
    }
}
