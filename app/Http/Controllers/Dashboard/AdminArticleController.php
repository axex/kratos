<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\Traits\ArticleManagerTrait;
use App\Repositories\Dashboard\CatogoryRepository;
use App\Repositories\Dashboard\IssueRepository;
use App\Repositories\PublishingArticleRepository;
use App\Http\Controllers\Controller;

class AdminArticleController extends Controller
{
    use ArticleManagerTrait;

    /**
     * AdminArticleController constructor.
     * @param PublishingArticleRepository $articleRepository
     * @param CatogoryRepository $categoryRepository
     * @param IssueRepository $issueRepository
     */
    public function __construct(
        PublishingArticleRepository $articleRepository,
        CatogoryRepository $categoryRepository,
        IssueRepository $issueRepository
    ) {
        $this->middleware('deny403', ['except' => 'index']);
        $this->indexView = 'dashboard.article.index';
        $this->editView = 'dashboard.article.edit';
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->issueRepository = $issueRepository;
    }
}
