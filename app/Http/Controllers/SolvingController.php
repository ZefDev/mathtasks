<?php

namespace App\Http\Controllers;

use App\Models\Solving;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolvingController extends Controller
{
    public function create(Request $request){
        $solving = new Solving;
        $solving->user_id = Auth::id();
        $solving->answerUser = $request->input('answer');
        $solving->task_id = $request->input('task_id');
        $solving->is_task_solved = $this->checkAnswer($solving->task_id,$solving->answerUser);
        $solving->save();
        return $solving;
    }

    public function checkAnswer($task_id,$answerUser){
        $answers = Task::find($task_id)->answers()->where([['answer','=',$answerUser]])->count();
        if (!empty($answers)){
            return true;
        }
        return false;
    }
}
