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
        $categories = factory(Category::class)->times(10)->make();
        Category::insert($categories->toArray());
        Category::create([
            'name' => '推荐',
            'slug' => 'recommend'
        ]);

        Category::create([
            'name' => '其他',
            'slug' => 'default'
        ]);
    }
}
