<?php
namespace App\Repositories;

use App\Models\ContributeArticle;
use App\Models\ContributeTag;
use App\Repositories\Traits\ArticleManagerTrait;
use Illuminate\Database\Eloquent\Model;

class ContributeArticleRepository
{
    use ArticleManagerTrait;

    /**
     * ContributeArticleRepository constructor.
     * @param ContributeArticle $article
     */
    public function __construct(ContributeArticle $article)
    {
        $this->article = $article;
    }
}