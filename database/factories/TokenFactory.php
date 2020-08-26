<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Token;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Token::class, function (Faker $faker) {
    return [
        'name' => Str::random(10),
        'token' => hash('sha256', Str::random(60)),
        'validated_on' => Carbon::now(),
    ];
});
