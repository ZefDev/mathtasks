<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){
        //$lastTask = Task::with()

        $lastTask = Task::with('user','theme','raitings')
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();
        //$avgrating = number_format((float)$task->raitings->avg('mark'), 2, '.', '');
        $topTask = Task::with('user','theme','raitings')
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();
        return Inertia::render('Dashboard', [
            'lastTask' => $lastTask,
             'topTask' => $topTask
        ]);
    }
}
