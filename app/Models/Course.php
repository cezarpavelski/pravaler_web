<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'institution_id',
        'name',
        'duration',
        'status',
    ];

    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }
}
