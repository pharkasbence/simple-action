<?php

namespace PharkasBence\SimpleAction;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ActionData
{
    protected array $validatedData;

    public function __construct(protected array $data)
    {        
        $this->validate();

        $this->hydrateProperties();
    }

    protected function validate(): void
    {
        $validator = Validator::make($this->data, $this->validationRules(), $this->validationMessages());

        $validator->validate();
    }

    protected function hydrateProperties()
    {
        foreach ($this->data as $key => $value) {
            $property = Str::camel($key);

            if (property_exists(get_called_class(), $property)) {
                $this->{$property} = $value;
            }
        }
    }
    
    protected function validationRules(): array
    {
        return [];
    }

    protected function validationMessages(): array
    {
        return [];
    }

    protected function toArray(array $fields = []): array
    {
        $result = [];

        $arrayFields = $fields 
            ? array_filter($this->data, fn ($key) => in_array($key, $fields), ARRAY_FILTER_USE_KEY)
            : $this->data;

        foreach ($arrayFields as $key => $value) {
            $property = Str::camel($key);

            if (property_exists(get_called_class(), $property)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}