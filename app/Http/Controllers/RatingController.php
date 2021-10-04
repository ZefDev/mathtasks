<?php

namespace App\Http\Controllers;

use App\Models\Raiting;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    protected $ratingService;
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }
    public function setRaiting(Request $request){
        $data = $request->only([
            'task_id',
            'mark'
        ]);
        $data['user_id'] = Auth::id();
        return $this->ratingService->saveRating($data);
    }
}
