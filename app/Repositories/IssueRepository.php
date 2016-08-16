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
        return $this->article->with(['tags', 'category'])->where('issue', $issue)->get()->groupBy('category_id');
    }


}