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

}