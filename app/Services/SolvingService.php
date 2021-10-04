<?php


namespace App\Services;

use App\Repositories\SolvingRepository;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class SolvingService
{
    protected $solvingRepository;

    /**
     * @return mixed
     */
    public function __construct(SolvingRepository $solvingRepository)
    {
        $this->solvingRepository = $solvingRepository;
    }

    public function getCountSolvedTasks($id){
        return $this->solvingRepository->getCountSolvedTasksByUserId($id);
    }

    public function getSolvingTask($taskId,$userId){
        return $this->solvingRepository->getSolvingTask($taskId,$userId);
    }

}

