<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function theme(){
        return $this->belongsTo(Theme::class, 'theme_id', 'id');
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
        return $this->hasMany('App\Models\Comment', 'id', 'task_id');
    }
    public function raitings() {
        return $this->hasMany('App\Models\Raiting', 'id', 'answer_id');
    }
    public function rating()
    {
        return $this->raitings()->avg("mark");
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
