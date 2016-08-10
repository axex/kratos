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
        $issues = $this->issue->latest('issue')->paginate(\Cache::get('page_size', 10));
        return $issues;
    }

    /**
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
     * 编辑期数
     *
     * @param int $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        $issue = $this->issue->findOrFail($id);
        return $issue;
    }

    public function update($issue, array $attributes)
    {
        return $issue->update($attributes);
    }
}