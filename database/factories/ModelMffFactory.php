<?php

use Faker\Generator as Faker;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

$factory->define(
    App\Models\Income::class,
    function (Faker $faker) {
        return [
            'user_id' => function () {
                return factory('App\Models\User')->create()->id;
            },
            'income_date' => Carbon\Carbon::now()->format('Y-m-d H:i'),
            'category_id' => function () {
                return factory('App\Models\Category')->create()->id;
            },
            'gross_amount' => '46000.00',
            'net_amount' => '27000.00',
            'description' => $faker->sentence
        ];
    }
);

$factory->define(
    App\Models\Category::class,
    function (Faker $faker) {
        return [
            'user_id' => function () {
                return factory('App\Models\User')->create()->id;
            },
            'type' => 'Income',
            'name' => $faker->word,
            'descriptions' => $faker->sentence
        ];
    }
);
