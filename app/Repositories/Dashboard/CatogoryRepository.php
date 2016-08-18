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

    /**
     * 过滤指定目录
     *
     * @param int $id
     * @return mixed
     */
    public function filter($id)
    {
        $categories = $this->category->where('id', '<>', $id)->latest()->get();
        return $categories;
    }
}