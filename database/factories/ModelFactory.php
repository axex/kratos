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

$dates = [
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s')
    ];

// 用户
$factory->define(App\Models\User::class, function (Faker\Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10)
    ], $dates);
});

// 分类
$factory->define(App\Models\Category::class, function (Faker\Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->unique()->word,
        'slug' => $faker->word,
        'desc' => $faker->paragraph
    ], $dates);
});

// 期数
$factory->define(App\Models\Issue::class, function (Faker\Generator $faker) use ($dates) {
        return array_merge([
            'issue' => $faker->unique()->numberBetween(1, 30),
            'published_at' => $faker->dateTimeThisYear
        ], $dates);
});

// 文章
$factory->define(App\Models\Article::class, function (Faker\Generator $faker) use ($dates) {
    $issueIds = \App\Models\Issue::lists('id')->toArray();
    $categoryIds = \App\Models\Category::lists('id')->toArray();
    return array_merge([
        'issue_id' => $faker->randomElement($issueIds),
        'category_id' => $faker->randomElement($categoryIds),
        'title' => $faker->sentence(),
        'desc' => $faker->paragraph,
        'url' => $faker->url,
        'presenter' => $faker->name,
        'is_check' => $faker->randomElement([0, 1])
    ], $dates);
});

// 标签
$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->unique()->word
    ], $dates);
});

// 文章和标签之间的关联关系
$factory->define(App\Models\ArticleTag::class, function (Faker\Generator $faker) use ($dates) {
    $articleIds = \App\Models\Article::lists('id')->toArray();
    $tagIds = \App\Models\Tag::lists('id')->toArray();
    return array_merge([
        'article_id' => $faker->randomElement($articleIds),
        'tag_id' => $faker->randomElement($tagIds),
    ], $dates);
});

// 订阅用户
$factory->define(App\Models\Subscribe::class, function (Faker\Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'confirm_code' => str_random(48),
        'is_confirmed' => $faker->randomElement([0, 1]),
    ], $dates);
});