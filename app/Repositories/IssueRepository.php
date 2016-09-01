<?php

namespace App\Repositories;

use App\Models\Issue;
use App\Repositories\Criteria\Repository;

class IssueRepository extends Repository
{
    protected function model()
    {
        return Issue::class;
    }

    public function all()
    {
        $issues = $this->model->latestByIssue()->get();
        return $issues;
    }

    /**
     * 已经发布的期数
     *
     * @return mixed
     */
    public function publishedIssues()
    {
        return $this->model->latest('issue')->published()->get();
    }

    /**
     * 获取指定数量的期数
     *
     * @param int $num
     * @return mixed
     */
    public function getIssues($num = 20)
    {
        return $this->model->latest('issue')->published()->limit($num)->get();
    }

    /**
     * 期数分页
     *
     * @return mixed
     */
    public function paginate()
    {
        $issues = $this->model->with('articles')->latestByIssue()->paginate(\Cache::get('page_size', 10));
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