<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'role_id' => function() {
            return factory(App\Models\Role::class)->create(['name' => 'user'])->id;
        },
    ];
});

$factory->state(App\Models\User::class, 'user', function (Faker\Generator $faker) {
    return [
        'role_id' => factory(App\Models\Role::class)->create(['name' => 'user'])->id,
    ];
});

$factory->state(App\Models\User::class, 'admin', function (Faker\Generator $faker) {
    return [
        'role_id' => factory(App\Models\Role::class)->create(['name' => 'admin'])->id,
    ];
});

$factory->define(App\Models\Design::class, function (Faker\Generator $faker) {
    return [
        'price' => 100,
        'image_name' => 'fakeimage.png',
        'comment' => 'This is a test comment',
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'category_id' => function () {
            return factory(App\Models\Category::class)->create()->id;
        },
        'name' => 'Medium',
        'width' => 200,
        'height' => 80,
        'price' => 1000,
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Bracelets',
    ];
});

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'address_id' => function (array $order) {
            return factory(App\Models\Address::class)->create(['email' => $order['email']])->id;
        },
    ];
});

$factory->state(App\Models\Order::class, 'for-guest', function (Faker\Generator $faker) {
    return [
        'user_id' => null
    ];
});

$factory->state(App\Models\Order::class, 'for-user', function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        }
    ];
});



$factory->define(App\Models\Address::class, function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'name' => 'John Doe',
        'street' => 'Example Road',
        'city' => 'Example City',
        'state' => 'Example State',
        'zip' => 33143,
        'country' => 'Example Country',
        'phone_number' => '1013002121',
        'comment' => 'Example comment',
    ];
});

$factory->state(App\Models\Address::class, 'with-user', function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        }
    ];
});

$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => 'user',
    ];
});
