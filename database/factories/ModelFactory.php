<?php

use Faker\Generator as Faker;
use Faker\Provider\Uuid;
use Illuminate\Support\Str;

$factory->define(
    App\Models\User::class,
    function (Faker $faker) {
        return [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
            'confirmed' => true,
            'confirmation_token' => str_random(25),
        ];
    }
);

$factory->state(
    App\Models\User::class,
    'unconfirmed',
    function () {
        return [
            'confirmed' => false
        ];
    }
);

$factory->state(
    App\Models\User::class,
    'administrator',
    function () {
        return [
            'name' => 'Tanvir'
        ];
    }
);

$factory->define(
    App\Models\Thread::class,
    function (Faker $faker) {
        $title = $faker->sentence;

        return [
            'user_id' => function () {
                return factory('App\Models\User')->create()->id;
            },
            'channel_id' => function () {
                return factory('App\Models\Channel')->create()->id;
            },
            'title' => $title,
            'body' => $faker->paragraph,
            'visits' => 0,
            'slug' => str_slug($title),
            'locked' => false,
            'pinned' => false
        ];
    }
);

$factory->define(
    App\Models\Channel::class,
    function (Faker $faker) {
        return [
            'name' => $faker->word,
            'slug' => $faker->word,
            'description' => $faker->sentence
        ];
    }
);

$factory->define(
    App\Models\Reply::class,
    function (Faker $faker) {
        return [
            'thread_id' => function () {
                return factory('App\Models\Thread')->create()->id;
            },
            'user_id' => function () {
                return factory('App\Models\User')->create()->id;
            },
            'body' => $faker->paragraph,
        ];
    }
);

$factory->define(
    \Illuminate\Notifications\DatabaseNotification::class,
    function (Faker $faker) {
        return [
            'id' => (string)Str::uuid(), //Laravel special unique identifier :)
            'type' => 'App\Notifications\ThreadWasUpdated',
            'notifiable_id' => function () {
                return auth()->id() ? : factory('App\Models\User')->create()->id;
            },
            'notifiable_type' => 'App\Models\User',
            'data' => ['foo' => 'bar']
        ];
    }
);
