<?php

namespace App\Http\Requests;

class CourseRequest
{
    public static function rules()
    {
        return [
            'institution_id' => 'int|required|exists:institutions,id',
            'name' => 'string|required',
            'duration' => 'date|required',
            'status' => 'boolean|required',
        ];
    }
}
