<?php

namespace App\Libraries;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageHandle
{

    public function fit($image, $width, $height){

        if (!File::isFile(config('image.path') . $image)){
            echo 1;
        }

        $extension = pathinfo($image, PATHINFO_EXTENSION);

        $imageOld = $image;

        if ((int)$width && (int)$height){
            $imageNew = 'cache/' . substr($image, 0, strrpos($image, '.')) . '-' . $width . '-' . $height . '.' . $extension;

            if (File::isFile(config('image.path') . $imageNew)){
                return config('image.url') . $imageNew;
            }

            // create new image with transparent background color
            $background = Image::canvas($width, $height);
            $image_resize = Image::make(config('image.path') . $image)->resize($width, $height, function ($c) {
                $c->aspectRatio();
            });
            $background->insert($image_resize, 'center')->save(config('image.path') . $imageNew);

            return config('image.url') . $imageNew;

        }else{
            return config('image.url') . $imageOld;
        }
    }
}