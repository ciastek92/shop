<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductPriceTypes::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word
    ];
});