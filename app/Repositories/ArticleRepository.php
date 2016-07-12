<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    protected $article;

    /**
     * ArticleRepository constructor.
     * @param $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function search($sql, $num)
    {
        return $this->article->whereRaw($sql)->paginate($num);
    }
}