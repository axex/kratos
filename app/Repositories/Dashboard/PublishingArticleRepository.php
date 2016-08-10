<?php
namespace App\Repositories\Dashboard;

use App\Models\PublishingArticle;

class PublishingArticleRepository
{
    protected $article;

    /**
     * PublishingArticleRepository constructor.
     * @param $article
     */
    public function __construct(PublishingArticle $article)
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
        $articles = $this->article->isCheck(1)->whereBetween('created_at', $values)->count();
        return $articles;
    }


}