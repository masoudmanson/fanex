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
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];


//    $table->increments('id');
//    $table->integer('user_id')->unique();
//    $table->string('api_token');
//    $table->string('firstname');
//    $table->string('lastname');
//    $table->string('account_number');
//    $table->string('mobile');
//    $table->enum('sex', ['Mr.', 'Ms.', 'Co.']);
//    $table->enum('identity_number', ['passport', 'national', 'registration', 'national_id']);
//    $table->string('address');
//    $table->string('place_of_birth');
//    $table->string('date_of_birth');
//    $table->string('postal_code');
//    $table->string('tel');
//    $table->string('fax');
//    $table->string('email')->unique();
//    $table->string('password');
//    $table->boolean('is_authorized');
//    $table->rememberToken();
//    $table->timestamps();
});
