<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function tasks(){
        return Task::select()->where([
            ['user_id', '=', Auth::user()->id]
        ])->orderBy('id', 'ASC')->get();
    }
}
