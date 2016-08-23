<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

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

    public function all()
    {
        $categories = $this->category->latest()->get();
        return $categories;
    }

    /**
     * 分类分页
     *
     * @return mixed
     */
    public function paginate()
    {
        $categories = $this->category->with('articles')->latest()->paginate(\Cache::get('page_size', 10));
        return $categories;
    }


    /**
     * 新建分类
     *
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        $category = $this->category->create($attributes);
        return $category;
    }

    /**
     * 查找指定分类
     *
     * @param int $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        $category = $this->category->findOrFail($id);
        return $category;
    }

    /**
     * 更新分类
     *
     * @param $category
     * @param array $attributes
     * @return mixed
     */
    public function update($category, array $attributes)
    {
        return $category->update($attributes);
    }

    /**
     * 删除分类
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $category = $this->findOrFail($id);
        return $category->delete();
    }

    /**
     * 推荐分类 id
     *
     * @return mixed
     */
    public function recommendedCategoryId()
    {
        return $this->category->recommend()->value('id');
    }

    /**
     * 默认分类 id
     *
     * @return mixed
     */
    public function defaultCategoryId()
    {
        return $this->category->default()->value('id');
    }

    /**
     * 缓存中取出推荐分类 id
     *
     * @return mixed
     */
    public function recommendedCategoryIdWithCache()
    {
        return Cache::remember('recommendedCategoryId', date('Y-m-d', strtotime('+1 week')), function () {
            return $this->recommendedCategoryId();
        });
    }

    /**
     * 缓存中取出默认分类 id
     *
     * @return mixed
     */
    public function defaultCategoryIdWithCache()
    {
        return Cache::remember('defaultCategoryId', date('Y-m-d', strtotime('+1 week')), function () {
            return $this->defaultCategoryId();
        });
    }

}