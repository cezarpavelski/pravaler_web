<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'cnpj',
        'status',
    ];

    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }
}
