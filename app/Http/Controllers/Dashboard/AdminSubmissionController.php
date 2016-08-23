<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Traits\ArticleManagerTrait;
use App\Http\Requests\Dashboard\ArticleRequest;
use App\Repositories\CategoryRepository;
use App\Repositories\ContributeArticleRepository;
use App\Repositories\IssueRepository;
use App\Repositories\PublishingArticleRepository;

class AdminSubmissionController extends Controller
{
    use ArticleManagerTrait;

    /**
     * AdminSubmissionController constructor.
     * @param ContributeArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @param IssueRepository $issueRepository
     */
    public function __construct(
        ContributeArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        IssueRepository $issueRepository
    ) {
        $this->indexView = 'dashboard.submission.index';
        $this->editView = 'dashboard.submission.edit';
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->issueRepository = $issueRepository;
    }

    /**
     * 更新投稿
     *
     * @param ArticleRequest $request
     * @param PublishingArticleRepository $publishingArticleRepository
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(
        ArticleRequest $request,
        PublishingArticleRepository $publishingArticleRepository,
        $id
    ) {
        $article = $this->articleRepository->findOrFail($id);
        if ($request->is_check == '1') {
            $status = $publishingArticleRepository->create($request->all());
            if ($status) {
                $this->articleRepository->delete($id);
            }
        } else {
            $this->articleRepository->update($article, $request->all());
        }

        return redirect(route($this->indexView))->with('message', trans('validation.notice.update_article_success'));
    }
}
