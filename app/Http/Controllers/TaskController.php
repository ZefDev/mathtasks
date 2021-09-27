<?php

namespace App\Http\Controllers;

use App\Models\Image;
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
        $task = Task::find($id);
        $is_task_solved = Solving::select()->where([
            ['is_task_solved','=',1],
            ['task_id','=',$id],
            ['user_id','=',Auth::id()],
        ])->count();
        return response()->json([
            'user' => $task->user,
            'task' => $task,
            'theme' => $task->theme,
            'answers' => $task->answers,
            'images' => $task->images,
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
}
