<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Student;
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

$factory->define(Student::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "cpf" => "222.222.222-44",
        "birth_date" => $faker->date(),
        "email" => $faker->email,
        "phone" => $faker->phoneNumber,
        "address" => $faker->streetAddress,
        "number" => $faker->randomNumber(),
        "district" => 'Centro',
        "city" => $faker->city,
        "country" => $faker->countryCode,
        "status" => 1,
        "course_id" => 1,
    ];
});
