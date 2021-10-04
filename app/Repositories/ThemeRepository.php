<?php

namespace App\Repositories;

use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class ThemeRepository{
    protected $theme;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    public function getAllThemes(){
        return $this->theme->all();
    }
}
