<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'cpf',
        'birth_date',
        'email',
        'phone',
        'address',
        'number',
        'district',
        'city',
        'country',
        'status',
        'course_id',
    ];

    protected $dates = [
        'birth_date',
    ];
}
