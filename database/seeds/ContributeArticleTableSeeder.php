<?php

use Illuminate\Database\Seeder;
use App\Models\ContributeArticle;

class ContributeArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contributeArticles = factory(ContributeArticle::class)->times(100)->make();
        ContributeArticle::insert($contributeArticles->toArray());
    }
}
