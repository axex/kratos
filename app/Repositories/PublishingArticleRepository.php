<?php

namespace App\Repositories;

use App\Models\PublishingArticle;
use App\Repositories\Criteria\ArticleManager;

class PublishingArticleRepository extends ArticleManager
{
    protected function model()
    {
        return PublishingArticle::class;
    }

    /**
     * 指定期数的文章
     *
     * @param $issue
     * @return static
     */
    public function articles($issue)
    {
        return $this->model->with(['tags', 'category'])->where('issue', $issue)->get()->groupBy('category_id');
    }
}