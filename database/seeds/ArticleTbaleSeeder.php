<?php

use Illuminate\Database\Seeder;

class ArticleTbaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = factory(\App\Article::class)->times(100)->make();
        \App\Article::insert($articles->toArray());
    }
}
