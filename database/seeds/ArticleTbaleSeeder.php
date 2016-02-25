<?php

use Illuminate\Database\Seeder;

class ArticleTbaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Article::class, 100)->create();
    }
}
