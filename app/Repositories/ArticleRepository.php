<?php

namespace App\Repositories;

use App\Models\PublishingArticle;

class ArticleRepository
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
        $kwords = \Request::get('kword', '');
        $kwords = explode(' ', $kwords);
        $sql = '';
        foreach ($kwords as $k => $kword) {
            $sql .= "title like '%" . $kword . "%'";
            $k != (count($kwords) - 1) ? $sql .= ' or ' : '';
        }
        return $this->article->whereRaw($sql)->paginate($num);
    }

    public function checkUrl($url)
    {
        return $this->article->whereUrl($url)->first();
    }

    public function create()
    {

    }
}