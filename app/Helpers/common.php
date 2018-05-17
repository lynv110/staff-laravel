<?php

if (!function_exists('mail_send')){
    function mail_send($info, $data, $view){
        return app('EmailHandle')->send($info, $data, $view);
    }
}

if (!function_exists('image_fit')){
    function image_fit($image, $width, $height){
        return app('ImageHandle')->fit($image, $width, $height);
    }
}

if (!function_exists('no_image')){
    function no_image(){
        return app('ImageHandle')->fit('no-image.jpg', '100', '100');
    }
}

if (!function_exists('datetime_to_list')){
    function datetime_to_list($date = null){
        if (!is_null($date) && $date && (substr($date, 0, 4) != '0000')) {
            return date('d-m-Y H:i:s', strtotime($date));
        }else{
            return '';
        }
    }
}
