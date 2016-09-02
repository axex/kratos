<?php

namespace App\Repositories\Criteria;

abstract class ArticleManager extends Repository
{
    /**
     * 指定时间内的文章数
     *
     * @param array $values
     * @return mixed
     */
    public function count(array $values)
    {
        $articles = $this->model->whereBetween('created_at', $values)->count();

        return $articles;
    }

    /**
     * 检查链接是否提交过
     *
     * @param $url
     *
     * @return mixed
     */
    public function checkUrl($url)
    {
        return $this->findBy('url', $url);
    }

    /**
     * 搜索文章
     *
     * @param $q
     *
     * @return mixed
     */
    public function search($q)
    {
        $articles = $this->model->where('title', 'like', $q . '%')->paginate(getPerPageRows());

        return $articles;
    }
}