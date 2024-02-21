<?php

namespace PharkasBence\SimpleAction;

use Illuminate\Support\Facades\App;

abstract class AbstractAction 
{
    private static function make()
    {
        return App::make(static::class);
    }

    public static function run(...$arguments)
    {
        return static::make()->handle(...$arguments);
    }
}