<?php


namespace App\Services;

use App\Repositories\UserRepository;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class UserService
{
    protected $userRepository;

    /**
     * @return mixed
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getActiveUsers(){
        return $this->userRepository->getActiveUsers();
    }

    public function delete($id){
        return $this->userRepository->delete($id);
    }

    public function setBlock($id){
        return $this->userRepository->setBlock($id);
    }

    public function setAdmin($id){
        return $this->userRepository->setAdmin($id);
    }

}

