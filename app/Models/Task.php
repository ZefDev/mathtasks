<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    use HasFactory;

    public function user(){
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
    public function theme(){
        return $this->hasOne('App\Models\Theme', 'id','theme_id');
    }

    public function images() {
        return $this->hasMany('App\Models\Image', 'id', 'image_id');
    }
    public function answers() {
        return $this->hasMany('App\Models\Answer', 'id', 'answer_id');
    }
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
