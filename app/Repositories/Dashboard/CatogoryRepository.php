<?php
namespace App\Repositories\Dashboard;

use App\Models\Category;

class CatogoryRepository
{
    protected $category;

    /**
     * CatogoryRepository constructor.
     * @param $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function all()
    {
        $categories = $this->category->latest()->get();
        return $categories;
    }
}