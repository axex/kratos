<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\ArticleManagerTrait;
use App\Repositories\ContributeArticleRepository;

class AdminSubmissionController extends Controller
{
    use ArticleManagerTrait;

    /**
     * AdminSubmissionController constructor.
     * @param ContributeArticleRepository $articleRepository
     */
    public function __construct(
        ContributeArticleRepository $articleRepository
    )
    {
        $this->indexView = 'dashboard.submission.index';
        $this->editView = 'dashboard.submission.edit';
        $this->articleRepository = $articleRepository;
    }
}
