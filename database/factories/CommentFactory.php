<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Article;
use Faker\Generator as Faker;

$factory->define(
    Comment::class, function (Faker $faker) {
        $randoms = Article::all()->pluck('id')->toArray();
        return [
            'article_id' => $faker->randomElement($randoms),
            'body' => $faker->paragraph($nbSentences = 10, $variableNbSentences = true),
        ];
    }
);
