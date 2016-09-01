<?php

namespace App\Repositories;

use App\Models\ContributeArticle;
use App\Repositories\Criteria\ArticleManager;

class ContributeArticleRepository extends ArticleManager
{
    protected function model()
    {
        return ContributeArticle::class;
    }

}