<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskRepository{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getAllTasks($page = 4){
        return $this->task->select()->with('user','theme')
            ->withAvg('raitings', 'mark')
            ->withCount('raitings')
            ->orderBy('id', 'DESC')
            ->paginate($page);
            //->get();
    }

    public function getAllTasksByUserId($id,$page = 4){
        return $this->task->select()->where([
            ['user_id', '=', $id]
        ])->withAvg('raitings','mark')
            ->withCount('raitings')
            ->orderBy('id', 'DESC')
            //->paginate($page);
            ->get();
    }

    public function getCountCreatedTasksByUserId($id){
        return $this->task->select()->where([
            ['user_id', '=', $id]
        ])->count();
    }

    public function getTaskById($id){
        return $this->task->with('user','theme','answers','images','raitings')->find($id);
    }

    public function getLastTasks($limit){
        return $this->task->with('user','theme','raitings')
            ->withAvg('raitings', 'mark')
            ->withCount('raitings')
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function getTopTasks($limit){
        return $this->task->with('user','theme','raitings')
            ->withAvg('raitings','mark')
            ->withCount('raitings')
            ->orderBy('raitings_avg_mark', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function save($data){

        $task = new $this->task;
        $task->theme_id = (int) $data['theme_id'];
        $task->name = $data['name'];
        $task->condition = $data['condition'];
        $task->user_id = $data['user_id'];
        $task->save();

        return $task;
    }

    public function update($data,$id){

        $task = $this->task->find($id);
        $task->theme_id = (int) $data['theme_id'];
        $task->name = $data['name'];
        $task->condition = $data['condition'];
        $task->user_id = $data['user_id'];
        $task->save();

        return $task;
    }

    public function delete($id){
        return $this->task->find($id)->delete();
    }

    public function getTaskBySearch($data){

        return $this->task->select()
            ->whereHas('comments', function ($query) use ($data) {
                $query->where('text', 'like', '%' .$data['text'].'%');
            })
            ->withAvg('raitings', 'mark')
            ->withCount('raitings')
            ->orWhere('condition', 'like', '%' .$data['text'].'%')
            ->orWhere('name', 'like', '%' .$data['text'].'%')
            ->orderBy('id', 'DESC')
            ->get();
    }
}
