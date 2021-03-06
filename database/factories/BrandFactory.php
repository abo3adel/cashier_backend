<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\Type;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'typeId' => factory(Type::class),
        'name' => $faker->word,
        'price' => $faker->randomFloat(4, 0, 1000)
    ];
});
