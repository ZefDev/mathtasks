<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getActiveUsers(){
        return $this->user->select()->where([
            ['isDelete','=',false],
        ])->orderBy('id', 'ASC')->get();
    }
    public function delete($id){
        $user = $this->user->find($id);
        $user->isDelete = true;
        $user->name = "Deleted User";
        $user->email = "Deleted User";
        $user->profile_photo_path = "https://www.dropbox.com/s/y1pl7145jzzpn7k/fc15c8d9f8fe6b79f9778a26e8e03fd4.jpg?dl=1";
        $user->provider = "Deleted User";
        $user->provider_id = "Deleted User";
        return $user->save();
    }

    public function setBlock($id){
        $user = $this->user->find($id);
        $user->isBlock = !$user->isBlock;
        return $user->save();
    }

    public function setAdmin($id){
        $user = $this->user->find($id);
        $user->isAdmin = !$user->isAdmin;
        return $user->save();
    }
}
