<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductPrices::class, function (Faker $faker) {
    return [
        'price'=> $faker->randomDigitNotNull,
        'type_id' => \App\Models\ProductPriceTypes::all()->random(1)->first()->id,
    ];
});
