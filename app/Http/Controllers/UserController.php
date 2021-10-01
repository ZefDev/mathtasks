<?php

namespace App\Http\Controllers;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = User::select()->orderBy('id', 'ASC')->get();

        return Inertia::render('Admin/container',[
            'users' => $user,
        ]);
    }

    public function users(){
        return User::select()->orderBy('id', 'ASC')->get();
    }

    public function delete($id){
        $user = User::find($id);
        $user->tasks()->delete();
        $user->comments()->delete();
        return $user->delete();
    }

    public function setBlock($id){
        $user = User::find($id);
        $user->isBlock = !$user->isBlock;
        return $user->save();
    }

    public function setAdmin($id){
        $user = User::find($id);
        $user->isAdmin = !$user->isAdmin;
        return $user->save();
    }

}
