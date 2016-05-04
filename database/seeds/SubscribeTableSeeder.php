<?php

use Illuminate\Database\Seeder;

class SubscribeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscribes = factory(\App\Subscribe::class)->times(30)->make();
        \App\Subscribe::insert($subscribes->toArray());
    }
}
