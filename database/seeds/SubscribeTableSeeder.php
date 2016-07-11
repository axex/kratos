<?php

use Illuminate\Database\Seeder;
use App\Models\Subscribe;

class SubscribeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscribes = factory(Subscribe::class)->times(30)->make();
        Subscribe::insert($subscribes->toArray());
    }
}
