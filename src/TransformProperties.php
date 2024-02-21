<?php

namespace PharkasBence\SimpleAction;

use Illuminate\Support\Str;

// This must be in a trait because readonly properties are 
// not allowed to initialize in base classes
trait TransformProperties
{
    private function init()
    {
        foreach($this->validatedData as $key => $value) {
            $property = Str::camel($key);

            if (property_exists(get_called_class(), $property)) {
                $this->{$property} = $value;
            }
        }
    }

    public function toArray(?array $fields = null): array
    {
        $result = [];  
        $isFieldsEmpty = empty($fields);

        foreach($this->validatedData as $key => $value) {
            $property = Str::camel($key);

            if (property_exists(get_called_class(), $property)) {
                if ($isFieldsEmpty || in_array($key, $fields)) {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }
}