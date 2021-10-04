<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService){
        $this->commentService = $commentService;
    }

    public function createComment(Request $request){
        $data = $request->only([
            'task_id',
            'text',
        ]);
        $data['user_id'] = Auth::id();
        return $this->commentService->saveComment($data);
    }
    public function getComments($idTask){
        $comments = $this->commentService->getComments($idTask);
        return response()->json([
            'comments' => $comments,
        ]);
    }
}
