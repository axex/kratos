<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Category::class, 10)->create();
        Category::create([
            'name' => '推荐',
            'slug' => 'recommend'
        ]);

        Category::create([
            'name' => '其他',
            'slug' => 'other'
        ]);
    }
}
