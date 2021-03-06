<?php

use App\Models\User;
use App\Models\Category;
use App\Models\Issue;
use App\Models\PublishingArticle;
use App\Models\ContributeArticle;
use App\Models\Subscribe;
use App\Models\Tag;
use App\Models\Taggable;
use App\Models\SystemSetting;
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
    $issues = Issue::lists('issue')->toArray();
    $categoryIds = Category::lists('id')->toArray();
    return array_merge([
        'issue' => $faker->randomElement($issues),
        'category_id' => $faker->randomElement($categoryIds),
        'title' => $faker->sentence(),
        'desc' => $faker->paragraph,
        'url' => $faker->url,
        'presenter' => $faker->name
    ], $dates);
});

// 投稿
$factory->define(ContributeArticle::class, function (Generator $faker) use ($dates) {
    return array_merge([
        'title' => $faker->sentence(),
        'desc' => $faker->paragraph,
        'url' => $faker->url,
        'presenter' => $faker->name
    ], $dates);
});

// 文章标签
$factory->define(Tag::class, function (Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->unique()->word
    ], $dates);
});

// 文章和标签之间的关联关系
$factory->define(Taggable::class, function (Generator $faker) use ($dates) {
    $taggableIds = PublishingArticle::lists('id')->toArray();
    $tagIds = Tag::lists('id')->toArray();
    return [
        'tag_id' => $faker->randomElement($tagIds),
        'taggable_id' => $faker->randomElement($taggableIds),
        'taggable_type' => $faker->randomElement([PublishingArticle::class, ContributeArticle::class])
    ];
});

// 订阅用户
$factory->define(Subscribe::class, function (Generator $faker) use ($dates) {
    return array_merge([
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'confirm_code' => getVerifyCode(),
        'is_confirmed' => $faker->randomElement([0, 1]),
    ], $dates);
});

// 系统配置
$factory->define(SystemSetting::class, function (Generator $faker) {
    return [
      'website_title' => 'Kratos',
      'website_keywords' => 'K',
      'website_dsec' => '',
      'website_icp' => '',
      'page_size' => '10',
      'system_version' => 'alpha_1.0',
      'system_author' => 'Kratos',
      'system_author_website' => 'Kratos',
    ];
});