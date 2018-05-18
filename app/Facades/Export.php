<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
class Export extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Export';
    }
}