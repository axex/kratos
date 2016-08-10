<?php
namespace App\Repositories\Dashboard;

use App\Models\ContributeArticle;

class ContributeArticleRepository
{
    protected $article;

    /**
     * ContributeArticleRepository constructor.
     * @param $article
     */
    public function __construct(ContributeArticle $article)
    {
        $this->article = $article;
    }

    /**
     * 指定时间内的文章数
     *
     * @param array $values
     * @return mixed
     */
    public function count(array $values)
    {
        $articles = $this->article->isCheck(0)->whereBetween('created_at', $values)->count();
        return $articles;
    }
}