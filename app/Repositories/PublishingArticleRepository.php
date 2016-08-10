<?php

namespace App\Repositories;

use App\Models\PublishingArticle;
use Illuminate\Support\Facades\Request;

class PublishingArticleRepository
{
    protected $article;

    /**
     * ArticleRepository constructor.
     * @param $article
     */
    public function __construct(PublishingArticle $article)
    {
        $this->article = $article;
    }

    public function search($num = 15)
    {
        $q = e(Request::get('q'));
        return $this->article->where('title', 'like', $q . '%')->paginate($num);
    }
}