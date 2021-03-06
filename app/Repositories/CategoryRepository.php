<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Criteria\Repository;
use Illuminate\Support\Facades\Cache;

class CategoryRepository extends Repository
{
    protected function model()
    {
        return Category::class;
    }

    /**
     * 推荐分类 id
     *
     * @return mixed
     */
    public function recommendedCategoryId()
    {
        return $this->model->recommend()->value('id');
    }

    /**
     * 默认分类 id
     *
     * @return mixed
     */
    public function otherCategoryId()
    {
        return $this->model->other()->value('id');
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
    public function otherCategoryIdWithCache()
    {
        return Cache::remember('otherCategoryId', date('Y-m-d', strtotime('+1 week')), function () {
            return $this->otherCategoryId();
        });
    }

}
