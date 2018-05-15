<?php

if (!function_exists('flash_info')){
    function flash_info($message){
        return app('FlashHandle')->info($message);
    }
}

if (!function_exists('flash_success')){
    function flash_success($message){
        return app('FlashHandle')->success($message);
    }
}

if (!function_exists('flash_error')){
    function flash_error($message){
        return app('FlashHandle')->error($message);
    }
}

if (!function_exists('flash_warning')){
    function flash_warning($message){
        return app('FlashHandle')->warning($message);
    }
}