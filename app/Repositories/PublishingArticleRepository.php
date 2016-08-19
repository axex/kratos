<?php

namespace App\Repositories;

use App\Models\PublishingArticle;
use App\Repositories\Traits\ArticleManagerTrait;
use Illuminate\Support\Facades\Request;

class PublishingArticleRepository
{
    use ArticleManagerTrait;

    /**
     * ArticleRepository constructor.
     * @param $article
     */
    public function __construct(PublishingArticle $article)
    {
        $this->article = $article;
    }
}