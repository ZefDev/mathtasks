<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
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
        ])->orderBy('id', 'ASC')->get();
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
            $image = new Image;
            $image->link =Storage::disk('dropbox')->put('file.jpg', $reguest->file('file'));//Storage::putFile('imagesAnswer', $reguest->file('file'));
            $image->task_id = $task->id;
            $image->save();
        }
        return $task;
    }
}
