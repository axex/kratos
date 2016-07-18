<?php

use Illuminate\Database\Seeder;
use App\Models\ContributeTag;

class ContributeTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = factory(ContributeTag::class)->times(100)->make();
        ContributeTag::insert($tags->toArray());
    }
}
