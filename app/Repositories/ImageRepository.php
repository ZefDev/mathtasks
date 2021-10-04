<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository{
    protected $image;

    public function __construct(Image $image)
    {
        $this->image = $image;
    }

    public function save($data){
        $image = new $this->image;
        $image->link = $data['link'];
        $image->task_id = $data['task_id'];
        $image->save();
        return $image;
    }

    public function delete($id){
        return $this->image->find($id)->delete();
    }
}
