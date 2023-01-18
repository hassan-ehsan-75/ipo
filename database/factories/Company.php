<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'en_name'=>$faker->name(),
        'ar_name'=>$faker->name(),
        'code'=>$faker->word(),
        'phone1'=>$faker->phoneNumber,
        'phone2'=>$faker->phoneNumber,
        'capital'=>$faker->word(),
        
    ];
});
