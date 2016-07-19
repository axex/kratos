<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    protected $category;

    /**
     * CategoryRepository constructor.
     * @param $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getRecommendedCategoryId()
    {
        return $this->category->recommend()->value('id');
    }
}