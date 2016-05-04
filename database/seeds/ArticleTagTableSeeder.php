<?php

use Illuminate\Database\Seeder;

class ArticleTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articleTag = factory(\App\ArticleTag::class)->times(100)->make();
        \App\ArticleTag::insert($articleTag->toArray());
    }
}
