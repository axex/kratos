<?php

use Illuminate\Database\Seeder;
use App\Models\ArticleTag;

class ArticleTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articleTag = factory(ArticleTag::class)->times(100)->make();
        ArticleTag::insert($articleTag->toArray());
    }
}
