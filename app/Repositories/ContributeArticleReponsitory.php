<?php
namespace App\Repositories;

use App\Models\ContributeArticle;
use App\Models\ContributeTag;

class ContributeArticleReponsitory
{
    protected $article;
    protected $tag;


    /**
     * ContributeArticleReponsitory constructor.
     * @param ContributeArticle $article
     * @param ContributeTag $tag
     */
    public function __construct(ContributeArticle $article, ContributeTag $tag)
    {
        $this->article = $article;
        $this->tag = $tag;
    }

    public function checkUrl($url)
    {
        return $this->article->whereUrl($url)->first();
    }

    public function create(array $attributes = [])
    {
        return $this->article->create($attributes);
    }

    public function updateOrCreateTags(array $attributes = [])
    {
        return $this->tag->updateOrCreate($attributes);
    }
}