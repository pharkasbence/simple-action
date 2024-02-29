<?php

namespace PharkasBence\SimpleAction;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ActionData
{
    protected array $validatedData;

    public function __construct(array $data)
    {        
        $this->validatedData = $this->validate($data);

        $this->hydrateProperties();
    }

    protected function validate(array $data): array
    {
        $validator = Validator::make($data, $this->validationRules(), $this->validationMessages());

        $validator->validate();

        return $validator->validated();
    }

    protected function hydrateProperties()
    {
        foreach($this->validatedData as $key => $value) {
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

    protected function toArray(?array $fields = null): array
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