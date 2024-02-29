<?php

namespace PharkasBence\SimpleAction;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

abstract class AbstractActionData
{
    protected array $validatedData;

    public function __construct(array $data)
    {        
        $this->validatedData = $this->validate($data);

        $this->init();
    }

    protected function validate(array $data): array
    {
        $validator = Validator::make($data, $this->rules(), $this->validationMessages());

        $validator->validate();

        return $validator->validated();
    }

    protected function init()
    {
        foreach($this->validatedData as $key => $value) {
            $property = Str::camel($key);

            if (property_exists(get_called_class(), $property)) {
                $this->{$property} = $value;
            }
        }
    }

    protected abstract function rules(): array;
    
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