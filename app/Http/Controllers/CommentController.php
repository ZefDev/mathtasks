<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function createComment(Request $request){
        $comment = new Comment;
        $comment->task_id= $request->input('task_id');
        $comment->text=$request->input('text');
        $comment->user_id = Auth::id();
        return $comment->save();
    }
    public function getComments($idTask){
        $comments = Comment::with('user','likes','dislike','like')->where([
            ['task_id','=',$idTask],
        ])->get();
        return response()->json([
            'comments' => $comments,
        ]);
    }
}
