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

    public function recommendedCategoryId()
    {
        return $this->category->recommend()->value('id');
    }

    public function defaultCategoryId()
    {
        return $this->category->default()->value('id');
    }

    public function recommendedCategoryIdWithCache()
    {
        return Cache::remember('recommendedCategoryId', date('Y-m-d', strtotime('+1 week')), function () {
            return $this->recommendedCategoryId();
        });
    }

    public function defaultCategoryIdWithCache()
    {
        return Cache::remember('defaultCategoryId', date('Y-m-d', strtotime('+1 week')), function () {
            return $this->defaultCategoryId();
        });
    }

}