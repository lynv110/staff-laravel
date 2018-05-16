<?php

if (!function_exists('mail_init')){
    function mail_init($info = []){
        return app('EmailHandle')->init($info);
    }
}

if (!function_exists('mail_send')){
    function mail_send($info){
        return app('EmailHandle')->send($info);
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