<?php

namespace PharkasBence\SimpleAction;

use Illuminate\Support\Facades\Validator;

abstract class AbstractActionData
{
    protected array $validatedData;

    public function __construct(array $data)
    {        
        $this->validatedData = $this->validate($data);
    }

    protected function validate(array $data): array
    {
        $validator = Validator::make($data, $this->rules(), $this->messages());

        $validator->validate();

        return $validator->validated();
    }

    protected abstract function rules(): array;
    
    protected function messages(): array
    {
        return [];
    }
}