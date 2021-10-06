<?php


namespace App\Services;

use App\Repositories\ImageRepository;
use Exception;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Spatie\Dropbox\Client as Client;
use Spatie\FlysystemDropbox\DropboxAdapter;


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
//            $temp_data = array();
//            $temp_link =Storage::disk('dropbox')->put('', $file);
//            $temp_data['link'] = Storage::disk('dropbox')->url($temp_link);
//            $temp_data['task_id'] = $task_id;
//            $this->imageRepository->save($temp_data);
//            $temp_link =Storage::disk('dropbox')->put('', $file);
//
//            $filename = '/text1.txt';
//            $adapter = \Storage::disk('dropbox')->getAdapter();
//            $client = $adapter->getClient();
//            //dd($client);
//            $link = $client->createTemporaryDirectLink($filename);
//            //dd($temp_link);
            $temp_data = array();
            $client = new Client("dSEFL7pT0DoAAAAAAAAAAY0neghsQ_bZoHm5Q24wM7y2EPJf1Ocv-HsCz075ix3K");
            $temp_link = "/".Storage::disk('dropbox')->put('', $file);
            $arr = array( "audience"=> "public",
                "access"=> "viewer",
                "requested_visibility"=> "public",
                "allow_download"=> true);
            $sharedLink = str_replace("?dl=0", "?raw=1", $client->createSharedLinkWithSettings($temp_link,$arr)['url']);
            $temp_data['link'] = $sharedLink;
            $temp_data['task_id'] = $task_id;
            $this->imageRepository->save($temp_data);
        }
        return true;
    }

    public function deleteImage($id){
        return $this->imageRepository->delete($id);
    }

}

