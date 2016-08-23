<?php

namespace App\Repositories;

use App\Models\Issue;
use App\Models\PublishingArticle;

class IssueRepository
{
    protected $issue;

    protected $article;

    /**
     * IssueRepository constructor.
     * @param Issue $issue
     * @param PublishingArticle $article
     */
    public function __construct(Issue $issue, PublishingArticle $article)
    {
        $this->issue = $issue;
        $this->article = $article;
    }

    public function all()
    {
        $issues = $this->issue->latestByIssue()->get();
        return $issues;
    }

    /**
     * 已经发布的期数
     *
     * @return mixed
     */
    public function publishedIssues()
    {
        return $this->issue->latest('issue')->published()->get();
    }

    /**
     * 获取指定数量的期数
     *
     * @param int $num
     * @return mixed
     */
    public function getIssues($num = 20)
    {
        return $this->issue->latest('issue')->published()->limit($num)->get();
    }

    /**
     * 期数下的文章
     *
     * @param $issue
     * @return static
     */
    public function articles($issue)
    {
        return $this->article->with(['tags', 'category'])->where('issue', $issue)->get()->groupBy('category_id');
    }

    /**
     * 期数分页
     *
     * @return mixed
     */
    public function paginate()
    {
        $issues = $this->issue->with('articles')->latestByIssue()->paginate(\Cache::get('page_size', 10));
        return $issues;
    }

    /**
     * 搜索期数
     *
     * @param string|int $q
     * @return mixed
     */
    public function search($q)
    {
        $issues = $this->issue->where('issue', $q)->paginate(\Cache::get('page_size', 10));
        return $issues;
    }

    /**
     * 新建期数
     *
     * @param array $attributes
     * @return static
     */
    public function create(array $attributes)
    {
        $issue = $this->issue->create($attributes);
        return $issue;
    }

    /**
     * 查找指定期数
     *
     * @param int $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        $issue = $this->issue->findOrFail($id);
        return $issue;
    }

    /**
     * 更新期数
     *
     * @param $issue
     * @param array $attributes
     * @return mixed
     */
    public function update($issue, array $attributes)
    {
        return $issue->update($attributes);
    }

    /**
     * 删除期数
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $issue = $this->findOrFail($id);
        return $issue->delete();
    }

    /**
     * 批量删除
     *
     * @param int | array $ids
     * @return mixed
     */
    public function batchDelete($ids)
    {
        return $this->issue->whereIn('id', $ids)->delete();
    }
}