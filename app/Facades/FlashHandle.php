<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
class FlashHandle extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FlashHandle';
    }
}