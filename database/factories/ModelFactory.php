<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Issue;
use App\Models\PublishingArticle;
use App\Models\PublishingTag;
use App\Models\PublishingArticleTag;
use App\Models\ContributeArticle;
use App\Models\ContributeTag;
use App\Models\ContributeArticleTag;
use App\Models\Subscribe;
use Faker\Generator;

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
$factory->define(User::class, function (Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10)
    ], $dates);
});

// 分类
$factory->define(Category::class, function (Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->unique()->word,
        'slug' => $faker->word,
        'desc' => $faker->paragraph
    ], $dates);
});

// 期数
$factory->define(Issue::class, function (Generator $faker) use ($dates) {
        return array_merge([
            'issue' => $faker->unique()->numberBetween(1, 30),
            'published_at' => $faker->dateTimeThisYear
        ], $dates);
});

// 文章
$factory->define(PublishingArticle::class, function (Generator $faker) use ($dates) {
    $issueIds = Issue::lists('id')->toArray();
    $categoryIds = Category::lists('id')->toArray();
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

// 文章标签
$factory->define(PublishingTag::class, function (Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->unique()->word
    ], $dates);
});

// 文章和标签之间的关联关系
$factory->define(PublishingArticleTag::class, function (Generator $faker) use ($dates) {
    $articleIds = PublishingArticle::lists('id')->toArray();
    $tagIds = PublishingTag::lists('id')->toArray();
    return array_merge([
        'article_id' => $faker->randomElement($articleIds),
        'tag_id' => $faker->randomElement($tagIds),
    ], $dates);
});

// 投稿
$factory->define(ContributeArticle::class, function (Generator $faker) use ($dates) {
    return array_merge([
        'title' => $faker->sentence(),
        'desc' => $faker->paragraph,
        'url' => $faker->url,
        'presenter' => $faker->name,
        'is_check' => $faker->randomElement([0, 1])
    ], $dates);
});

// 投稿标签
$factory->define(ContributeTag::class, function (Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->unique()->firstName
    ], $dates);
});

// 投稿和标签之间的关联关系
$factory->define(ContributeArticleTag::class, function (Generator $faker) use ($dates) {
    $articleIds = ContributeArticle::lists('id')->toArray();
    $tagIds = ContributeTag::lists('id')->toArray();
    return array_merge([
        'article_id' => $faker->randomElement($articleIds),
        'tag_id' => $faker->randomElement($tagIds),
    ], $dates);
});

// 订阅用户
$factory->define(Subscribe::class, function (Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'confirm_code' => str_random(48),
        'is_confirmed' => $faker->randomElement([0, 1]),
    ], $dates);
});