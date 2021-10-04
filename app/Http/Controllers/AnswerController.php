<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Services\AnswerService;

class AnswerController extends Controller
{
    protected $answerService;

    public function __construct(AnswerService $answerService){
        $this->answerService = $answerService;
    }
    public function delete($id){
        return $this->answerService->deleteAnswer($id);
    }
}
