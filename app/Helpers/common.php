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