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

    /**
     * 已经发布的期数
     *
     * @return mixed
     */
    public function publishedIssues()
    {
        return $this->withAndLatest([], 'issue')->published()->get();
    }

    /**
     * 获取指定数量的期数
     *
     * @param int $num
     * @return mixed
     */
    public function getIssues($num = 20)
    {
        return $this->model->latestByIssue()->published()->limit($num)->get();
    }
}