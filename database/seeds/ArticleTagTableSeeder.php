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
        // insert 是 Query Builder 里面的方法，不会自动维护 created_at 和 updated_at 这两个字段
        $articleTag = factory(ArticleTag::class)->times(100)->make();
        ArticleTag::insert($articleTag->toArray());
    }
}
