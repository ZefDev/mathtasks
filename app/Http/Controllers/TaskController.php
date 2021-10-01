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
use Inertia\Inertia;

class TaskController extends Controller
{

    public function indexAllTasks(){

        $lastTask = Task::select()->with('user','theme')
            ->withAvg('raitings', 'mark')
            ->withCount('raitings')
            ->orderBy('id', 'DESC')
            ->get();
        return Inertia::render('AllTasks/AllTasks', [
            'lastTask' => $lastTask,
        ]);
    }

    public function indexMyTasks(){

        $solved = Solving::select()->where([
            ['user_id', '=', Auth::user()->id],
            ['is_task_solved', '=', 1],
        ])->count();

        $created = Task::select()->where([
            ['user_id', '=', Auth::user()->id]
        ])->count();

        return Inertia::render('MyTasks/container', [
            'created'=>$created,
            'solved'=>$solved
        ]);
    }
    public function indexNewTask () {
        return Inertia::render('MyTasks/New/container');
    }
    public function indexViewTasks($id){
        return Inertia::render('MyTasks/View/container');
    }
    public function indexEditTask($id){
        return Inertia::render('MyTasks/Edit/container');
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

    public function delete($id){
        return Task::find($id)->delete();
    }

    public function tasks(){
        return Task::select()->where([
            ['user_id', '=', Auth::user()->id]
        ])->orderBy('id', 'DESC')->get();
    }

    public function getTaskCurrentUser(){
        return Task::select()->where([
            ['user_id', '=', Auth::user()->id]
        ])->withAvg('raitings','mark')
            ->withCount('raitings')
            ->orderBy('id', 'DESC')->get();
        //return Auth::user()->tasks->orderBy('id', 'DESC');
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
        $mark = 0;
        if(isset($rating->mark)){
            $mark = $rating->mark;
        }
        $avgrating = number_format((float)$task->raitings->avg('mark'), 2, '.', '');
        return response()->json([
            'task' => $task,
            'avgrating' =>$avgrating,
            'rating' =>$mark,
            'is_task_solved' => $is_task_solved,
        ]);
    }

}
