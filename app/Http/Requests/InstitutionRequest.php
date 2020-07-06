<?php

namespace App\Http\Requests;

class InstitutionRequest
{
    public static function rules()
    {
        return [
            'name' => 'string|required',
            'cnpj' => 'string|required|regex:/^[0-9]{2}.[0-9]{3}.[0-9]{3}\/[0-9]{4}-[0-9]{2}+$/',
            'status' => 'boolean|required',
        ];
    }
}
