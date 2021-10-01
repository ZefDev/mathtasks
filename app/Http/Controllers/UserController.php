<?php

namespace App\Http\Controllers;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = User::select()->where([
            ['isDelete','=',false],
        ])->orderBy('id', 'ASC')->get();

        return Inertia::render('Admin/container',[
            'users' => $user,
        ]);
    }

    public function users(){
        return User::select()->where([
            ['isDelete','=',false],
        ])->orderBy('id', 'ASC')->get();
    }

    public function delete($id){
        $user = User::find($id);
        $user->isDelete = true;
        $user->name = "Deleted User";
        $user->email = "Deleted User";
        $user->profile_photo_path = "https://www.dropbox.com/s/y1pl7145jzzpn7k/fc15c8d9f8fe6b79f9778a26e8e03fd4.jpg?dl=1";
        $user->provider = "Deleted User";
        $user->provider_id = "Deleted User";
        return $user->save();
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
