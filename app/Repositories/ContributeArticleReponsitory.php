<?php
namespace App\Repositories;

use App\Models\ContributeArticle;
use App\Models\ContributeTag;
use Illuminate\Database\Eloquent\Model;

class ContributeArticleReponsitory
{
    protected $article;


    /**
     * ContributeArticleReponsitory constructor.
     * @param ContributeArticle $article
     */
    public function __construct(ContributeArticle $article)
    {
        $this->article = $article;
    }

    /**
     * 检查投稿 url 是否已经提交过
     *
     * @param $url
     * @return mixed
     */
    public function checkUrl($url)
    {
        return $this->article->whereUrl($url)->first();
    }


    /**
     * 新建投稿文章
     *
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        return $this->article->create($attributes);
    }
}