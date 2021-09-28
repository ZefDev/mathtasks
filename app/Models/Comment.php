<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    //protected $with = ['user'];

    public function task(){
        return $this->belongsTo(Task::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function likes() {
        return $this->hasMany(Like::class );//'App\Models\Comment', 'task_id', 'id'
    }
    public function like() {
        return $this->likes()->where([
            ['type_like','=',1],
        ]);//'App\Models\Comment', 'task_id', 'id'
    }
    public function dislike() {
        return $this->likes()->where([
            ['type_like','=',0],
        ]);//'App\Models\Comment', 'task_id', 'id'
    }
}
