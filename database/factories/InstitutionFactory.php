<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Institution;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Models Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Institution::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "cnpj" => "00.000.000/0000-22",
        "status" => 1,
    ];
});
