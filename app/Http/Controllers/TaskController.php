<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\Raiting;
use App\Models\User;
use App\Models\Solving;
use App\Models\Task;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function tasks(){
        return Task::select()->where([
            ['user_id', '=', Auth::user()->id]
        ])->orderBy('id', 'DESC')->get();
    }

    public function create(Request $reguest){
        $task = new Task;
        $task->theme_id=(int) $reguest->input('theme_id');
        $task->name=$reguest->input('name');
        $task->condition=$reguest->input('condition');
        $task->user_id = Auth::id();
        $task->save();

        foreach (json_decode($reguest->input('answers')) as $item){
            $answer = new Answer;
            $answer->answer = $item->name;
            $answer->task_id = $task->id;
            $answer->save();
        }

        if($reguest->has('file')){
            $files = $reguest->file('file');
            foreach ($files as $file) {
                $image = new Image;
                $temp_link =Storage::disk('dropbox')->put('', $file);//Storage::putFile('imagesAnswer', $reguest->file('file'));
                $image->link = Storage::disk('dropbox')->url($temp_link);
                $image->task_id = $task->id;
                $image->save();
            }
        }
        return $task;
    }

    public function update(Request $reguest,$id){

        $task = Task::find($id);
        $task->theme_id=(int) $reguest->input('theme_id');
        $task->name=$reguest->input('name');
        $task->condition=$reguest->input('condition');
        $task->save();

        foreach (json_decode($reguest->input('answers')) as $item){
            if (isset($item->id)){
                $answer = Answer::find($item->id);
            }else{
                $answer = new Answer;
            }
            $answer->answer = $item->answer;
            $answer->task_id = $task->id;
            $answer->save();
        }

        if($reguest->has('file')) {
            $files = $reguest->file('file');
            foreach ($files as $file) {
                $image = new Image;
                $temp_link = Storage::disk('dropbox')->put('', $file);//Storage::putFile('imagesAnswer', $reguest->file('file'));
                $image->link = Storage::disk('dropbox')->url($temp_link);
                $image->task_id = $task->id;
                $image->save();
            }
        }

        return $task;
    }

    public function getTaskCurrentUser(){
        return Task::select()->where([
            ['user_id', '=', Auth::user()->id]
        ])->orderBy('id', 'DESC')->get();
        //return Auth::user()->tasks->orderBy('id', 'DESC');
    }
    public function delete($id){
        return Task::find($id)->delete();
    }
    public function getById($id){
        $task = Task::with('user','theme','answers','images','raitings')->find($id);//,'images','answers','theme','user'
        $is_task_solved = Solving::select()->where([
            ['is_task_solved','=',1],
            ['task_id','=',$id],
            ['user_id','=',Auth::id()],
        ])->count();
        $rating = Raiting::select()->where([
            ['task_id','=',$id],
            ['user_id','=',Auth::id()],
        ])->first();

        return response()->json([
            'task' => $task,
            'avgrating' =>bcdiv($task->raitings->avg('mark'), 1, 2),
            'rating' => $rating->mark,
            'is_task_solved' => $is_task_solved,
        ]);
    }

    public function getUserAchievements(){
        $solved = Solving::select()->where([
            ['user_id', '=', Auth::user()->id],
            ['is_task_solved', '=', 1],
        ])->count();
        $created = Task::select()->where([
            ['user_id', '=', Auth::user()->id]
        ])->count();
        return array(
            'created'=>$created,
            'solved'=>$solved
        );
    }

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

    public function like(Request $request){
        $like= Like::select()->where([
            ['comment_id','=',$request->input('comment_id')],
            ['user_id', '=', Auth::user()->id]
        ])->first();
        if ($like && $like->type_like == $request->input('type_like')){
            Like::destroy($like->id);
        }
        else{
            $like = Like::updateOrCreate([
                //Add unique field combo to match here
                //For example, perhaps you only want one entry per user:
                ['comment_id','=',$request->input('comment_id')],
                ['user_id', '=', Auth::user()->id]
            ],[
                'comment_id'     => $request->input('comment_id'),
                'user_id' => Auth::user()->id,
                'type_like'    => $request->input('type_like'),
            ]);
        }
        return true;
    }

    public function setRaiting(Request $request){
        $rait = Raiting::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            ['task_id','=',$request->input('task_id')],
            ['user_id', '=', Auth::user()->id]
        ],[
            'task_id'     => $request->input('task_id'),
            'user_id' => Auth::user()->id,
            'mark'    => $request->input('mark'),
        ]);

        return $rait;
    }
}
