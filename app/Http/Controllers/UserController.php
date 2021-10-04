<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Services\UserService;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }
    public function index(){
        $user = $this->userService->getActiveUsers();
        return Inertia::render('Admin/container',[
            'users' => $user,
        ]);
    }

    public function users(){
        return $this->userService->getActiveUsers();
    }

    public function delete($id){
        return $this->userService->delete($id);
    }

    public function setBlock($id){
        $this->userService->setBlock($id);
    }

    public function setAdmin($id){
        $this->userService->setAdmin($id);
    }

}
