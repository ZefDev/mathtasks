<?php

namespace App\Services;
use App\Repositories\ThemeRepository;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class ThemeService{
    protected $themeRepository;

    /**
     * @return mixed
     */
    public function __construct(ThemeRepository $themeRepository)
    {
        $this->themeRepository = $themeRepository;
    }

    public function getAll(){
        return $this->themeRepository->getAllThemes();
    }
}

