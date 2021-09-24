<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raiting extends Model
{
    use HasFactory;

    public function task(){
        return $this->hasOne('App\Models\Task','id','task_id');
    }
    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
