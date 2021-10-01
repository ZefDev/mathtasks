<?php

namespace App\Http\Controllers;

use App\Models\Raiting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
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
