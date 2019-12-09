<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(
    Article::class, function (Faker $faker) {
        $name = $faker->unique()->name;
        return [
            'name' => $name,
            'body' => $faker->paragraph($nbSentences = 100, $variableNbSentences = true),
            'slug' => str_slug($name),
            'creator' => 1,
        ];
    }
);
