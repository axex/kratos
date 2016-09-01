<?php

namespace App\Repositories\Criteria;

abstract class ArticleManager extends Repository
{
    /**
     * 所有文章
     *
     * @param bool $with 关系预载入
     * @return mixed
     */
    public function all($with = false)
    {
        $articles = tap($this->model->latest(), function ($query) use ($with) {
            !$with ? : $query->with('category');
        })->paginate(\Cache::get('page_size', 10));
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
     * @return mixed
     */
    public function search($q)
    {
        $articles = $this->model->where('title', 'like', $q . '%')->paginate(\Cache::get('page_size', 10));
        return $articles;
    }

    /**
     * 删除单篇文章
     *
     * @param $id
     * @return bool|null
     */
    public function delete($id)
    {
        $article = $this->findOrFail($id);
        return $article->delete();
    }

    /**
     * 批量删除文章
     *
     * @param mixed $values
     */
    public function batchDelete($values)
    {
        $this->model->whereIn('id', $values)->delete();
    }
}