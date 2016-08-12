<?php

use Illuminate\Database\Seeder;
use App\Models\PublishingArticleTag;

class PublishingArticleTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert 是 Query Builder 里面的方法，不会自动维护 created_at 和 updated_at 这两个字段
        $articleTag = factory(PublishingArticleTag::class)->times(20)->make();
        PublishingArticleTag::insert($articleTag->toArray());
    }
}
