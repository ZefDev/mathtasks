<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){

        $lastTask = Task::with('user','theme','raitings')
            ->withAvg('raitings', 'mark')
            ->withCount('raitings')
            ->orderBy('id', 'DESC')
            ->limit(4)
            ->get();

        $topTask = Task::with('user','theme','raitings')
            ->withAvg('raitings','mark')
            ->withCount('raitings')
            ->orderBy('raitings_avg_mark', 'DESC')
            ->limit(4)
            ->get();
        return Inertia::render('Dashboard', [
            'lastTask' => $lastTask,
             'topTask' => $topTask
        ]);
    }
}
