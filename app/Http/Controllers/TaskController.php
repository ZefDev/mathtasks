<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Task;
use App\Models\Answer;
use App\Services\TaskService;
use App\Services\SolvingService;
use App\Services\ThemeService;
use App\Services\RatingService;
use App\Services\AnswerService;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TaskController extends Controller
{
    protected $taskService;
    protected $solvingService;
    protected $themeService;
    protected $ratingService;
    protected $answerService;
    protected $imageService;

    /**
     * @return mixed
     */
    public function __construct(TaskService $taskService,
                                SolvingService $solvingService,
                                ThemeService $themeService,
                                RatingService $ratingService,
                                AnswerService $answerService,
                                ImageService $imageService)
    {
        $this->taskService = $taskService;
        $this->solvingService = $solvingService;
        $this->themeService = $themeService;
        $this->ratingService = $ratingService;
        $this->answerService = $answerService;
        $this->imageService = $imageService;
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

        $data = $reguest->only([
            'theme_id',
            'name',
            'condition'
        ]);
        $data['user_id'] = Auth::id();
        $task = $this->taskService->saveTask($data);

        $dataAnswer = json_decode($reguest->input('answers'));
        $this->answerService->saveAnswer($dataAnswer,$task->id);

        if($reguest->has('file')){
            $this->imageService->saveImages($reguest->file('file'),$task->id);
        }
        return $task;
    }

    public function update(Request $reguest,$id){

        $data = $reguest->only([
            'theme_id',
            'name',
            'condition'
        ]);
        $data['user_id'] = Auth::id();
        $task = $this->taskService->updateTask($data,$id);

        $dataAnswer = json_decode($reguest->input('answers'));
        $this->answerService->updateAnswer($dataAnswer,$task->id);

        if($reguest->has('file')){
            $this->imageService->saveImages($reguest->file('file'),$task->id);
        }

        return $task;
    }

    public function delete($id){
        return $this->taskService->deleteTask($id);
    }

    public function tasks(){
        return Task::select()->where([
            ['user_id', '=', Auth::user()->id]
        ])->orderBy('id', 'DESC')->get();
    }

    public function getTaskCurrentUser(){
        $tasks = $this->taskService->getAllCurentUser(Auth::user()->id);
        return response()->json(['tasks'=>$tasks]);
    }

    public function getTaskBySearch(Request $request){

        $data = $request->only([
            'text',
        ]);

        $tasks = $this->taskService->getTaskBySearch($data);
        return response()->json(['tasksSearch'=>$tasks]);
    }
}
