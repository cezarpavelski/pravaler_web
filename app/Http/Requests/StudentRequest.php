<?php

namespace App\Http\Requests;

class StudentRequest
{
    public static function rules()
    {
        return [
            'course_id' => 'int|required|exists:courses,id,deleted_at,NULL',
            'name' => 'string|required',
            'cpf' => 'string|required|regex:/^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}+$/',
            'birth_date' => 'date|required',
            'email' => 'email|required',
            'phone' => 'string|required',
            'address' => 'string|required',
            'number' => 'string|required',
            'district' => 'string|required',
            'city' => 'string|required',
            'country' => 'string|required',
            'status' => 'boolean|required',
        ];
    }
}
