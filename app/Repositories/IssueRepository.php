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


}