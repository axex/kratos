<?php

use App\Models\Category;
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
        Category::create([
            'name' => '推荐',
            'slug' => 'recommend'
        ]);

        Category::create([
            'name' => '其他',
            'slug' => 'default'
        ]);
        $categories = factory(Category::class)->times(10)->make();
        Category::insert($categories->toArray());
    }
}
