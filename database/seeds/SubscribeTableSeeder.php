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
        factory(\App\Subscribe::class, 30)->create();
    }
}
