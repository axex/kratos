<?php

use Illuminate\Database\Seeder;
use App\Models\ContributeArticleTag;

class ContributeArticleTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articleTag = factory(ContributeArticleTag::class)->times(20)->make();
        ContributeArticleTag::insert($articleTag->toArray());
    }
}
