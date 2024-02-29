<?php

namespace PharkasBence\SimpleAction;

use Illuminate\Support\Facades\App;

class Action 
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