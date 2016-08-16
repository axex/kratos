<?php
namespace App\Repositories\Dashboard;

use App\Models\PublishingArticle;
use App\Models\Tag;

class PublishingArticleRepository
{
    protected $article;
    protected $isCheck = 1;

    /**
     * PublishingArticleRepository constructor.
     * @param PublishingArticle $article
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

    /**
     * 搜索文章
     *
     * @param $q
     * @return mixed
     */
    public function search($q)
    {
        $articles = $this->article->where('title', 'like', $q . '%')->isCheck($this->isCheck)->paginate(\Cache::get('page_size', 10));
        return $articles;
    }

    /**
     * 新建文章
     *
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes = [])
    {
        $article = $this->article->create($attributes);
        return $article;
    }

    public function findOrFail($id)
    {
        $article = $this->article->findOrFail($id);
        return $article;
    }
}