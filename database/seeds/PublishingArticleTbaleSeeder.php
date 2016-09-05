<?php

use Illuminate\Database\Seeder;
use App\Models\PublishingArticle;

class PublishingArticleTbaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = factory(PublishingArticle::class)->times(50)->make();
        PublishingArticle::insert($articles->toArray());
    }
}
