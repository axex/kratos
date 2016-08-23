<?php

namespace App\Repositories;

use App\Models\ContributeArticle;
use App\Models\ContributeTag;
use App\Repositories\Criteria\ArticleManager;
use App\Repositories\Traits\ArticleManagerTrait;
use Illuminate\Database\Eloquent\Model;

class ContributeArticleRepository extends ArticleManager
{

    protected function model()
    {
        return ContributeArticle::class;
    }
}