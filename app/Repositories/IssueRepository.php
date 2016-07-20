<?php
namespace App\Repositories;

use App\Models\Issue;

class IssueRepository
{
    protected $issue;
    /**
     * IssueRepository constructor.
     * @param Issue $issue
     */
    public function __construct(Issue $issue)
    {
        $this->issue = $issue;
    }

    public function allIssues()
    {
        return $this->issue->latest('issue')->published()->get();
    }

    public function getIssues($num = 20)
    {
        return $this->issue->latest('issue')->published()->limit($num)->get();
    }

    public function articles($issue)
    {
        return $this->issue->whereIssue($issue)->published()->first()->articles->groupBy('category_id');
    }


}