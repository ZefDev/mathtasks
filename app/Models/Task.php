<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{

    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class); //'user_id', 'id'
    }

    public function theme(){
        return $this->belongsTo(Theme::class); //,'user_id', 'id'
    }

    public function images() {
        return $this->hasMany(Image::class, 'task_id', 'id');
    }
    public function answers() {
        return $this->hasMany(Answer::class, 'task_id', 'id');
    }

//    public function answers()
//    {
//        return $this->belongsTo(Answer::class,'task_id','id');
//    }
    public function comments() {
        return $this->hasMany(Comment::class );//'App\Models\Comment', 'task_id', 'id'
    }

    public function raitings() {
        return $this->hasMany(Raiting::class);
    }

    public function avgRaitings() {
        return $this->hasMany(Raiting::class)
            ->select('*', DB::raw('AVG(mark) AS avg_rating'))
            ->get();
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag','tag_tasks');
    }

    protected $fillable = [
        'name',
        'condition',
        'theme_id',
//        'image_id',
//        'answer_id',
    ];
}
