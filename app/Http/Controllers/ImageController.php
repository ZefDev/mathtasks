<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Services\ImageService;

class ImageController extends Controller
{
    protected $imageService;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function delete($id){
        return $this->imageService->deleteImage($id);
    }
}
