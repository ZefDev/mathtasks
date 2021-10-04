<?php

namespace App\Http\Controllers;

use App\Services\ThemeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    protected $themeService;
    public function __construct(ThemeService $themeService){
        $this->themeService = $themeService;
    }
    public function themes(){
        return $this->themeService->getAll();
    }
}
