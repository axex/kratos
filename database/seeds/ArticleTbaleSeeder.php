<?php

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleTbaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = factory(Article::class)->times(100)->make();
        Article::insert($articles->toArray());
    }
}
