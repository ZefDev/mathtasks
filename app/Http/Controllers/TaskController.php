<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Task;
use App\Models\Answer;
use App\Services\TaskService;
use App\Services\SolvingService;
use App\Services\ThemeService;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TaskController extends Controller
{
    protected $taskService;
    protected $solvingService;
    protected $themeService;

    /**
     * @return mixed
     */
    public function __construct(TaskService $taskService,
                                SolvingService $solvingService,
                                ThemeService $themeService,
                                RatingService $ratingService)
    {
        $this->taskService = $taskService;
        $this->solvingService = $solvingService;
        $this->themeService = $themeService;
        $this->ratingService = $ratingService;
    }
    public function indexAllTasks(){
        $lastTask = $this->taskService->getAll();
        return Inertia::render('AllTasks/AllTasks', [
            'lastTask' => $lastTask,
        ]);
    }

    public function indexMyTasks(){

        $solved = $this->solvingService->getCountSolvedTasks(Auth::user()->id);
        $created = $this->taskService->getCountCreatedTasks(Auth::user()->id);
        $tasks = $this->taskService->getAllCurentUser(Auth::user()->id);

        return Inertia::render('MyTasks/container', [
            'created'=>$created,
            'solved'=>$solved,
            'tasks'=>$tasks
        ]);
    }
    public function indexNewTask () {
        $themes = $this->themeService->getAll();
        return Inertia::render('MyTasks/New/container', [
            'themes'=>$themes,
        ]);
    }
    public function indexViewTask($id){
        $task = $this->taskService->getTaskById($id);
        $is_task_solved = $this->solvingService->getSolvingTask($id,Auth::id());
        $rating = $this->ratingService->getRatingCurentTask($id,Auth::id());

        $mark = 0;
        if(isset($rating->mark)){
            $mark = $rating->mark;
        }
        $avgrating = number_format((float)$task->raitings->avg('mark'), 2, '.', '');

        return Inertia::render('MyTasks/View/container', [
                'task' => $task,
                'avgrating' =>$avgrating,
                'rating' =>$mark,
                'is_task_solved' => $is_task_solved,
            ]);
    }
    public function indexEditTask($id){
        $task = $this->taskService->getTaskById($id);
        $themes = $this->themeService->getAll();

        return Inertia::render('MyTasks/Edit/container',[
            'task' => $task,
            'themes'=>$themes,
        ]);
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

}
