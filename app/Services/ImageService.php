<?php


namespace App\Services;

use App\Repositories\ImageRepository;
use Exception;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class ImageService
{
    protected $imageRepository;

    /**
     * @return mixed
     */
    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function saveImages($data,$task_id){
        foreach ($data as $file) {
            $temp_data = array();
            $temp_link =Storage::disk('dropbox')->put('', $file);
            $temp_data['link'] = Storage::disk('dropbox')->url($temp_link);
            $temp_data['task_id'] = $task_id;
            $this->imageRepository->save($temp_data);
        }
        return true;
    }

    public function deleteImage($id){
        return $this->imageRepository->delete($id);
    }

}

