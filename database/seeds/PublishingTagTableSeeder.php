<?php

use Illuminate\Database\Seeder;
use App\Models\PublishingTag;

class PublishingTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = factory(PublishingTag::class)->times(100)->make();
        PublishingTag::insert($tags->toArray());
    }
}
