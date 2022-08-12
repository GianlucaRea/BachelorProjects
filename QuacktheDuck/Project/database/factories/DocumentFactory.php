<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Document::class, function (Faker $faker) {
    return [
        //

        'id_user_document'  => 1,
        'title' => $faker->word(10),
        'university' => $faker->word(10),
        'course' => $faker->word(10),
        'subject' => $faker->word(10),
        'source' => $faker->word(10),
    ];
});
