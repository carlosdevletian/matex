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

$factory->state(App\Models\User::class, 'owner', function (Faker\Generator $faker) {
    factory(App\Models\CurrencyRate::class)->create(['currency_code' => 'cop']);
    return [
        'role_id' => factory(App\Models\Role::class)->create(['name' => 'owner'])->id,
    ];
});

$factory->define(App\Models\Design::class, function (Faker\Generator $faker) {
    return [
        'price' => 100,
        'image_name' => 'fakeimage.png',
        'comment' => 'This is a test comment',
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'category_id' => function () {
            return factory(App\Models\Category::class)->create()->id;
        },
        'is_predesigned' => false
    ];
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'category_id' => function () {
            return factory(App\Models\Category::class)->create()->id;
        },
        'name' => 'Medium',
        'width' => 200,
        'length' => 80,
        'price' => 1000,
        'display_position' => $faker->numberBetween($min = 1, $max = 20),
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => 'Bracelets',
        'image_name' => 'bracelets.png'
    ];
});

$factory->define(App\Models\Accessory::class, function (Faker\Generator $faker) {
    return [
        'category_id' => function () {
            return factory(App\Models\Category::class)->create()->id;
        },
        'name' => 'Hook',
        'price' => 1000,
        'image_name' => 'some_image.png'
    ];
});

$factory->define(App\Models\Order::class, function (Faker\Generator $faker) {
    return [
        'reference_number' => $faker->ean13,
    ];
});

$factory->state(App\Models\Order::class, 'for-guest', function (Faker\Generator $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'address_id' => function (array $order) {
            return factory(App\Models\Address::class)->create(['email' => $order['email']])->id;
        }
    ];
});

$factory->state(App\Models\Order::class, 'for-user', function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'address_id' => function (array $order) {
            return factory(App\Models\Address::class)->create(['user_id' => $order['user_id']])->id;
        }
    ];
});

$factory->state(App\Models\Order::class, 'active', function (Faker\Generator $faker) {
    $activeStatusId = App\Models\Status::active()[0];
    return [
        'status_id' => function () use ($activeStatusId) {
            return factory(App\Models\Status::class)
                    ->create(['id' => $activeStatusId])
                    ->id;
        },
    ];
});

$factory->state(App\Models\Order::class, 'canceled', function (Faker\Generator $faker) {
    $canceledStatusId = App\Models\Status::canceled()[0];
    return [
        'status_id' => function () use ($canceledStatusId) {
            return factory(App\Models\Status::class)
                    ->create(['id' => $canceledStatusId])
                    ->id;
        },
    ];
});

$factory->state(App\Models\Order::class, 'unpaid', function (Faker\Generator $faker) {
    $unpaidStatusId = App\Models\Status::unpaid()[0];
    return [
        'status_id' => function () use ($unpaidStatusId) {
            return factory(App\Models\Status::class)
                    ->create(['id' => $unpaidStatusId])
                    ->id;
        },
    ];
});

$factory->state(App\Models\Order::class, 'paid', function (Faker\Generator $faker) {
    $paidStatusId = App\Models\Status::paid()[0];
    return [
        'status_id' => function () use ($paidStatusId) {
            return factory(App\Models\Status::class)
                    ->create(['id' => $paidStatusId])
                    ->id;
        },
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
        },
        'email' => null
    ];
});

$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => 'user',
    ];
});

$factory->define(App\Models\Item::class, function (Faker\Generator $faker) {
    return [
        'cart_id' => null,
        'order_id' => null,
        'product_id' => function () {
            return factory(App\Models\Product::class)->create()->id;
        },
        'design_id' => function () {
            return factory(App\Models\Design::class)->create()->id;
        },
        'accessory_id' => function () {
            return factory(App\Models\Accessory::class)->create()->id;
        },
        'quantity' => $faker->numberBetween($min = 5, $max = 1000),
        'unit_price' => $faker->numberBetween($min = 10, $max = 100),
        'total_price' => $faker->numberBetween($min = 1000, $max = 9000),
    ];
});

$factory->define(App\Models\Cart::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->create()->id;
        }
    ];
});

$factory->define(App\Models\Status::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence($nbWords = 5, $variableNbWords = true),
        'color' => $faker->hexcolor
    ];
});

$factory->define(App\Models\CategoryPricing::class, function (Faker\Generator $faker) {
    return [
        'category_id' => function() {
            return factory(App\Models\Category::class)->create()->id;
        },
        'min_quantity' => 10,
        'unit_price' => 150
    ];
});

$factory->define(App\Models\CurrencyRate::class, function (Faker\Generator $faker) {
    return [
        'currency_code' => $faker->currencyCode,
        'to_dollar' => $faker->numberBetween($min = 1, $max = 9999)
    ];
});
