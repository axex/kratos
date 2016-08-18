<?php
namespace App\Repositories\Dashboard;

use App\Models\Issue;

class IssueRepository
{
    protected $issue;

    /**
     * IssueRepository constructor.
     * @param $issue
     */
    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    public function all()
    {
        $issues = $this->issue->latestByIssue()->get();
        return $issues;
    }

    /**
     * 分页查找期数
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
     * 过滤指定期数
     *
     * @param int $issue
     * @return mixed
     */
    public function filter($issue)
    {
        $issues = $this->issue->where('issue', '<>', $issue)->latestByIssue()->get();
        return $issues;
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

    public function batchDelete($ids)
    {
        return $this->issue->whereIn('id', $ids)->delete();
    }
}