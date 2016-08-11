<?php
namespace App\Repositories\Dashboard;

use App\Models\PublishingArticle;

class PublishingArticleRepository
{
    protected $article;
    protected $isCheck = 1;

    /**
     * PublishingArticleRepository constructor.
     * @param $article
     */
    public function __construct(PublishingArticle $article)
    {
        $this->article = $article;
    }

    public function all()
    {
        $articles = $this->article->isCheck($this->isCheck)->latest()->paginate(\Cache::get('page_size', 10));
        return $articles;
    }

    /**
     * 指定时间内的文章数
     *
     * @param array $values
     * @return mixed
     */
    public function count(array $values)
    {
        $articles = $this->article->isCheck($this->isCheck)->whereBetween('created_at', $values)->count();
        return $articles;
    }

    public function search($q)
    {
        $articles = $this->article->where('title', 'like', $q . '%')->isCheck($this->isCheck)->paginate(\Cache::get('page_size', 10));
        return $articles;
    }

}