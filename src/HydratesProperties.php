<?php

namespace PharkasBence\SimpleAction;

use Illuminate\Support\Str;

trait HydratesProperties
{
    // this has to be in a trait because readonly 
    // properties cannot be initialized in base classes
    protected function hydrateProperties()
    {
        foreach ($this->data as $key => $value) {
            $property = Str::camel($key);

            if (property_exists(get_called_class(), $property)) {
                $this->{$property} = $value;
            }
        }
    }
}